# AI Queue Performance Fixes - Implementation Guide

## 🎯 Changes Made

### 1. **Increased Job Timeout (120 → 600 seconds)**
- **File**: `app/Jobs/ProcessAiGeneration.php`
- **Change**: Updated `$timeout` from 120 to 600 seconds (10 minutes)
- **Impact**: Jobs processing long prompts (modul ajar, e-kinerja) won't timeout prematurely

### 2. **Implemented Retry Logic**
- **File**: `app/Jobs/ProcessAiGeneration.php`
- **Change**: Added `$tries = 3` and `$backoff = [60, 120, 180]`
- **Impact**: Failed jobs automatically retry 3 times with exponential backoff (1, 2, 3 minutes between retries)
- **Benefits**:
  - Transient API errors don't cause permanent failures
  - User doesn't need to manually resubmit
  - Stuck jobs get released and retried

### 3. **Created Queue Cleanup Command**
- **File**: `app/Console/Commands/CleanupStuckAiQueue.php`
- **Usage**: `php artisan ai-queue:cleanup-stuck --minutes=30`
- **Impact**: Automatically marks old pending/processing jobs as failed
- **Recommendation**: Schedule this as cron job every 30 minutes

### 4. **Created Queue Retry Command**
- **File**: `app/Console/Commands/RetryFailedAiQueue.php`
- **Usage**: `php artisan ai-queue:retry-failed --limit=10`
- **Impact**: Allows admin to retry failed jobs manually or automatically
- **Recommendation**: Can be triggered by super admin via monitoring dashboard or scheduled

### 5. **Multiple Queue Workers Configuration**
- **File**: `supervisord.conf`
- **Setup**: Configured 5 total workers:
  - 2 workers on "high" queue (untuk admin/priority)
  - 3 workers on "default" queue (untuk regular users)
- **Impact**: Can process 5 jobs in parallel instead of 1

---

## 📋 How to Run (Development/Testing)

### Option A: Run Manually (Recommended for Local Development)

Open **3-5 separate terminal tabs** and run:

```bash
# Tab 1: High Priority Queue (Admin)
php artisan queue:work database --queue=high --sleep=3 --tries=3 --timeout=600

# Tab 2-3: Default Queue (Regular Users) - Run this command in 2 tabs
php artisan queue:work database --queue=default --sleep=3 --tries=3 --timeout=600

# Tab 4-5: Additional Default Queue workers (Optional, run if needed)
php artisan queue:work database --queue=default --sleep=3 --tries=3 --timeout=600
```

**Flags explained:**
- `--sleep=3`: Check for jobs every 3 seconds
- `--tries=3`: Retry failed jobs 3 times
- `--timeout=600`: Maximum 600 seconds per job

### Option B: Run with Supervisor (Production)

1. **Install Supervisor** (macOS):
```bash
brew install supervisor
```

2. **Start Supervisor with config**:
```bash
supervisord -c /path/to/project/supervisord.conf
```

3. **Monitor Supervisor**:
```bash
supervisorctl -c /path/to/project/supervisord.conf
```

---

## 🧹 Maintenance Commands

### Check Queue Status
```bash
# See how many jobs in queue
php artisan queue:monitor
```

### Cleanup Stuck Jobs (run every 30 minutes)
```bash
# Mark jobs stuck >30 minutes as failed
php artisan ai-queue:cleanup-stuck --minutes=30

# Or from super admin dashboard
```

### Retry Failed Jobs
```bash
# Retry last 10 failed jobs
php artisan ai-queue:retry-failed --limit=10
```

### View Queue Logs
```bash
# Check Laravel logs for queue processing details
tail -f storage/logs/laravel.log | grep ProcessAiGeneration
```

---

## 🎬 How to Test (Beta Testing)

### Test 1: Generate Modul Ajar (Heaviest)
1. Login as teacher
2. Go to "Modul Ajar" feature
3. Fill form and click Generate
4. You'll see loading screen with queue ID
5. **Expected**: Should complete in 5-10 minutes (previously would hang forever)

### Test 2: Generate E-Kinerja
1. Login as ASN/Employee user
2. Go to "E-Kinerja" (SKP)
3. Fill form with employee data
4. Click Generate
5. **Expected**: Should complete in 5-8 minutes

### Test 3: Generate E-Kinerja Atasan (Supervisor Feedback)
1. Login as supervisor
2. Go to "E-Kinerja Atasan"
3. Fill form with subordinate data
4. Click Generate
5. **Expected**: Should complete in 5-8 minutes

### Check Monitoring Dashboard
1. Login as Super Admin
2. Go to Dashboard → Queue Monitoring
3. You should see:
   - ✓ Jobs moving from "pending" → "processing" → "completed"
   - ✓ No stuck jobs anymore
   - ✓ Retry attempts visible if any

### Simulate Error & Retry
1. Stop all queue workers
2. Generate a Modul Ajar (stays in "pending")
3. Start queue workers again
4. Job should automatically resume and complete

---

## 📊 Expected Behavior After Fix

| Scenario | Before | After |
|----------|--------|-------|
| Modul Ajar Generation | ⏳ Hangs forever | ✅ Takes 5-10 min, completes |
| E-Kinerja Generation | ⏳ Hangs forever | ✅ Takes 5-8 min, completes |
| E-Kinerja Atasan | ⏳ Hangs forever | ✅ Takes 5-8 min, completes |
| Job Timeout | ❌ Fails at 2 min | ✅ Waits up to 10 min |
| Transient Error | ❌ Permanent fail | ✅ Auto-retry 3x |
| Stuck Jobs | ❌ Stuck forever | ✅ Cleaned up after 30 min |
| Parallel Processing | ❌ 1 job at a time | ✅ 5 jobs in parallel |

---

## 🔍 Monitoring via Super Admin Dashboard

The monitoring page shows:
- **Total Queue**: Total jobs ever submitted
- **Pending & Processing**: Jobs currently being worked on
- **Completed**: Successful jobs
- **Failed**: Jobs that failed after 3 retries
- **Queue Table**: Detailed list with status, retry attempts, error messages

---

## ⚙️ Schedule for Production (Crontab)

Add these to your crontab (`crontab -e`) or Laravel Scheduler:

```bash
# Every 30 minutes: cleanup stuck jobs
*/30 * * * * cd /path/to/project && php artisan ai-queue:cleanup-stuck --minutes=30

# Every 2 hours: retry failed jobs (optional)
0 */2 * * * cd /path/to/project && php artisan ai-queue:retry-failed --limit=20
```

Or in Laravel Scheduler (`app/Console/Kernel.php`):
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('ai-queue:cleanup-stuck', ['--minutes' => 30])
        ->everyThirtyMinutes()
        ->withoutOverlapping();
    
    $schedule->command('ai-queue:retry-failed', ['--limit' => 20])
        ->everyTwoHours()
        ->withoutOverlapping();
}
```

---

## 🚀 Deployment Checklist

- [ ] Pulled latest changes from repo
- [ ] Updated `ProcessAiGeneration.php` with new timeout/tries
- [ ] Created cleanup & retry commands
- [ ] Tested locally with multiple queue workers
- [ ] Verified all 3 features complete successfully
- [ ] Setup supervisor config on production
- [ ] Started multiple queue workers
- [ ] Added cron jobs for cleanup & monitoring
- [ ] Tested via super admin dashboard
- [ ] Monitored logs for 24 hours
- [ ] Ready to push to production

---

## 📞 Troubleshooting

### Jobs still stuck in "processing"?
```bash
# Run cleanup immediately
php artisan ai-queue:cleanup-stuck --minutes=5
```

### Need to force retry all failed jobs?
```bash
php artisan ai-queue:retry-failed --limit=999
```

### Queue workers not processing jobs?
```bash
# Check if workers are running
ps aux | grep "queue:work"

# Check Laravel logs
tail -f storage/logs/laravel.log
```

### Database queue table getting too large?
```bash
# Clean up very old completed jobs (keep last 1000)
php artisan queue:prune-failed --hours=72
```

---

**Version**: 1.0  
**Last Updated**: 2026-07-11  
**Status**: Ready for Beta Testing
