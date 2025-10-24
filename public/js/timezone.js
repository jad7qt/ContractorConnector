// Function to get user current timezone and send to PHP scripts
document.addEventListener('DOMContentLoaded', () => {
  const usertimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  const time_input = document.getElementById('timezoneInput');
  if (time_input) {
    time_input.value = usertimezone;
  }
});