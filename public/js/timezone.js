// Function to get user current timezone and send to PHP scripts
document.addEventListener('DOMContentLoaded', () => {
  const usertimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  console.log("User's timezone:", usertimezone);
  fetch('save_timezone.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ timezone: usertimezone })
  });
});