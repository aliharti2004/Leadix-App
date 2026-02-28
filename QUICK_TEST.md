# Quick Test Script

## Test the notification system instantly:

1. **Check Browser Console** (`F12`)
   - Should see: `✅ Notification system ready`
   - Should see: `🔔 Notification polling started (every 5 seconds)`

2. **Move a deal to Won:**
   ```
   php artisan tinker
   $deal = Deal::find(2);
   $deal->deal_stage_id = 5;  # Won stage
   $deal->save();
   ```

3. **Within 5 seconds:**
   - Badge should show increased number
   - Sound should play (success chime)
   - Console shows: `🔔 NEW NOTIFICATION DETECTED!`

4. **Manual refresh:**
   ```javascript
   // In browser console:
   refreshNotifications();
   ```

## Current Status:
- ✅ Sounds: Web Audio API (no files needed)
- ✅ Polling: Every 5 seconds (instant feel)
- ✅ Badge: Auto-updates
- ✅ Colors: Left accent bars with semantic colors

## Troubleshooting:
If still not seeing updates:
1. Hard refresh: `Ctrl + Shift + R`
2. Check console for errors
3. Verify scripts are loading (Network tab)
