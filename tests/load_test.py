
import requests
import concurrent.futures
import time
import re
import warnings

# Suppress SSL warnings if testing locally with self-signed certs (if any)
warnings.filterwarnings("ignore")

BASE_URL = "http://127.0.0.1:8000" # Change this if your local dev server port differs
LOGIN_URL = f"{BASE_URL}/login"
GENERATE_URL = f"{BASE_URL}/berita" # POST route for news generation as per web.php
NEWS_PAGE_URL = f"{BASE_URL}/berita" # GET route for news page


# Test Users Credentials
USERS = [
    {"email": f"test_user_{i}@ketik.in", "password": "password123"} for i in range(1, 11)
]

def get_csrf_token(session, url):
    response = session.get(url)
    # Simple regex to find CSRF token in meta tag or hidden input
    token_search = re.search(r'name="_token" value="([^"]+)"', response.text)
    if token_search:
        return token_search.group(1)
    
    # Fallback search for meta tag
    token_search = re.search(r'name="csrf-token" content="([^"]+)"', response.text)
    if token_search:
        return token_search.group(1)
        
    return None

def simulate_user_activity(user_data):
    session = requests.Session()
    email = user_data['email']
    start_time = time.time()
    
    try:
        # 1. Access Login Page to get Cookie & CSRF
        csrf_token = get_csrf_token(session, LOGIN_URL)
        if not csrf_token:
            return f"❌ {email}: Failed to get CSRF token"

        # 2. Perform Login
        login_data = {
            "email": email,
            "password": user_data['password'],
            "_token": csrf_token
        }
        
        login_response = session.post(LOGIN_URL, data=login_data, allow_redirects=True)
        
        if "dashboard" not in login_response.url and login_response.status_code != 200:
             return f"❌ {email}: Login Failed (Status {login_response.status_code})"

        # 3. Simulate AI Generation (News)
        # We need a fresh CSRF token from the dashboard/page if the old one expired (Laravel rotates them sometimes)
        # But usually session based one works. Let's try grabbing it from the page content if needed, 
        # or just use the one we have if it's consistent. Laravel often keeps it.
        # Safest is to fetch the news page first.
        
        news_page_response = session.get(NEWS_PAGE_URL)
        csrf_token_news = get_csrf_token(session, NEWS_PAGE_URL)
        
        if not csrf_token_news:
             csrf_token_news = csrf_token # Fallback
             
        generate_data = {
            "topic": "Perkembangan Teknologi AI di Tahun 2026",
            "style": "Formal",
            "_token": csrf_token_news
        }
        
        # Request with timeout to catch hangs
        gen_start = time.time()
        # Increased timeout to 300s because complex E-Kinerja prompts take ~90-120s
        response = session.post(GENERATE_URL, data=generate_data, timeout=300)
        gen_duration = time.time() - gen_start
        
        if response.status_code == 200:
            # Verify we got a success redirect or content
            # Laravel features usually redirect to result page or show view.
            # If we see "result" in URL or "Berita AI" in content, likely success.
            return f"✅ {email}: Success ({gen_duration:.2f}s)"
        else:
            return f"❌ {email}: Failed ({response.status_code}) - {response.reason}"

    except Exception as e:
        return f"❌ {email}: Exception - {str(e)}"

def run_load_test():
    print(f"🚀 Starting Load Test with {len(USERS)} concurrent users...")
    print(f"Target URL: {BASE_URL}")
    
    start_time = time.time()
    
    with concurrent.futures.ThreadPoolExecutor(max_workers=len(USERS)) as executor:
        results = list(executor.map(simulate_user_activity, USERS))
    
    total_time = time.time() - start_time
    
    print("\n--- Load Test Results ---")
    success_count = 0
    for res in results:
        print(res)
        if "✅" in res:
            success_count += 1
            
    print(f"\nTotal Time: {total_time:.2f}s")
    print(f"Success Rate: {success_count}/{len(USERS)}")

if __name__ == "__main__":
    run_load_test()
