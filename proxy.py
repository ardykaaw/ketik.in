"""
Server untuk Test Infografis AI — menggunakan Gemini untuk generate konten.
Jalankan: python3 proxy.py
Lalu buka: http://localhost:9000/test-infografis.html
"""

from http.server import HTTPServer, SimpleHTTPRequestHandler
from urllib.request import urlopen, Request
from urllib.parse import urlparse, parse_qs
import json, os, re

PORT = 9000


def read_env_key(env_path, key):
    """Baca nilai dari file .env"""
    try:
        with open(env_path) as f:
            for line in f:
                line = line.strip()
                if line.startswith(key + '='):
                    val = line.split('=', 1)[1].strip().strip('"').strip("'")
                    return val if val else None
    except Exception:
        pass
    return None


def generate_image_gemini(api_keys, prompt_text):
    """Generate gambar via Gemini 2.5 Flash Image dengan rotasi multi-key"""
    import random, base64
    from urllib.error import HTTPError

    keys = list(api_keys)
    random.shuffle(keys)
    last_err = None

    for i, key in enumerate(keys):
        url = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-image:generateContent?key={key}"
        payload = json.dumps({
            "contents": [{"parts": [{"text": prompt_text}]}],
            "generationConfig": {
                "responseModalities": ["IMAGE", "TEXT"],
            }
        }).encode()
        try:
            req = Request(url, data=payload, headers={"Content-Type": "application/json"})
            with urlopen(req, timeout=120) as resp:
                data = json.loads(resp.read())

            # Cari part yang berisi image
            for part in data["candidates"][0]["content"]["parts"]:
                if "inlineData" in part:
                    mime = part["inlineData"]["mimeType"]
                    img_bytes = base64.b64decode(part["inlineData"]["data"])
                    print(f"[Gemini] ✅ Image key #{i+1} — {len(img_bytes)//1024} KB, {mime}")
                    return img_bytes, mime

            raise Exception("Tidak ada gambar dalam respons Gemini")

        except HTTPError as e:
            body = e.read().decode(errors='replace')[:200]
            print(f"[Gemini] Key #{i+1} gagal ({e.code}): {body[:80]}...")
            last_err = f"HTTP {e.code}: {body}"
            if e.code == 429:
                continue
            else:
                raise Exception(f"HTTP Error {e.code}: {e.reason} — {body}")
        except Exception as e:
            if "Tidak ada gambar" in str(e):
                raise
            last_err = str(e)
            print(f"[Gemini] Key #{i+1} error: {e}")
            continue

    raise Exception(f"Semua {len(keys)} API key gagal. Last: {last_err}")


class Handler(SimpleHTTPRequestHandler):

    def do_OPTIONS(self):
        self.send_response(200)
        self._cors()
        self.end_headers()

    def do_POST(self):
        parsed = urlparse(self.path)
        if parsed.path == '/generate-infographic':
            length = int(self.headers.get('Content-Length', 0))
            body = json.loads(self.rfile.read(length))
            self._handle_infographic(body)
        else:
            self.send_response(404)
            self.end_headers()

    def _handle_infographic(self, body):
        topik = body.get('topik', 'Topik')
        jenis = body.get('jenis', 'tips')
        poin  = body.get('poin', '')
        warna = body.get('warna', 'blue')
        gaya  = body.get('gaya', 'modern')

        env_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), '.env')
        raw_keys = read_env_key(env_path, 'GEMINI_API_KEYS') or read_env_key(env_path, 'GEMINI_API_KEY')
        api_keys = [k.strip() for k in raw_keys.split(',') if k.strip()] if raw_keys else []

        if not api_keys:
            self._json_error(500, 'GEMINI_API_KEY / GEMINI_API_KEYS tidak ditemukan di .env')
            return

        print(f'[Gemini] {len(api_keys)} key(s) tersedia')

        warna_map = {
            'blue': 'blue and indigo', 'orange': 'warm orange and yellow',
            'green': 'green and teal', 'dark': 'dark navy with white text',
            'purple': 'purple and violet', 'red': 'red and coral'
        }
        gaya_map = {
            'modern': 'modern flat design', 'bold': 'bold colorful design',
            'minimal': 'minimalist clean design', 'corporate': 'corporate professional design'
        }
        jenis_map = {
            'tips': 'tips and tricks with numbered list and icons',
            'statistik': 'statistics with big numbers and charts',
            'proses': 'step-by-step process with arrows and flow',
            'perbandingan': 'comparison with two columns',
            'timeline': 'timeline with chronological events',
            'fakta': 'interesting facts with bold callout boxes'
        }

        poin_list = [p.strip() for p in poin.split('\n') if p.strip()]
        poin_text = '. '.join(f"{i+1}. {p}" for i, p in enumerate(poin_list)) if poin_list else ''

        prompt = (
            f"Create a high-quality professional infographic poster image. "
            f"Topic: \"{topik}\". "
            f"Type: {jenis_map.get(jenis, 'tips and tricks')}. "
        )
        if poin_text:
            prompt += f"Content points to include: {poin_text}. "
        prompt += (
            f"Design style: {gaya_map.get(gaya, 'modern flat design')}. "
            f"Color scheme: {warna_map.get(warna, 'blue and indigo')}. "
            f"The infographic must have clear readable text, professional typography, "
            f"organized sections with icons, clean layout. "
            f"All text must be in Indonesian (Bahasa Indonesia). "
            f"High resolution, print-ready quality."
        )

        try:
            print(f"[Gemini] Generating image for: {topik}")
            img_bytes, mime_type = generate_image_gemini(api_keys, prompt)

            self.send_response(200)
            self.send_header('Content-Type', mime_type)
            self.send_header('Content-Length', str(len(img_bytes)))
            self._cors()
            self.end_headers()
            self.wfile.write(img_bytes)

        except Exception as e:
            print(f"[Gemini] Error: {e}")
            self._json_error(500, str(e))

    def do_GET(self):
        super().do_GET()

    def _json_error(self, code, msg):
        self.send_response(code)
        self.send_header('Content-Type', 'application/json')
        self._cors()
        self.end_headers()
        self.wfile.write(json.dumps({'error': msg}).encode())

    def _cors(self):
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        self.send_header('Access-Control-Allow-Headers', 'Content-Type')

    def log_message(self, fmt, *args):
        pass


if __name__ == '__main__':
    os.chdir(os.path.dirname(os.path.abspath(__file__)))
    server = HTTPServer(('', PORT), Handler)
    print(f"✅ Server berjalan di http://localhost:{PORT}")
    print(f"   Buka: http://localhost:{PORT}/test-infografis.html")
    print(f"   Tekan Ctrl+C untuk stop.\n")
    server.serve_forever()
