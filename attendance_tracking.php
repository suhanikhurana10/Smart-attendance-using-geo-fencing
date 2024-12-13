<!DOCTYPE html>
<html>
<head>
  <title>Attendance with Geolocation</title>
</head>
<body>
  <h1>Attendance Tracking</h1>
  <button onclick="checkLocation()">Mark Attendance</button>
  <p id="status"></p>

  <script>
    const roomLat = 12.971598; // Replace with your room's latitude
    const roomLong = 77.594566; // Replace with your room's longitude
    const thresholdRadius = 50; // Radius in meters

    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371e3; // Earth's radius in meters
      const toRadians = (degree) => degree * (Math.PI / 180);

      const deltaLat = toRadians(lat2 - lat1);
      const deltaLon = toRadians(lon2 - lon1);

      const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
                Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                Math.sin(deltaLon / 2) * Math.sin(deltaLon / 2);

      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c; // Distance in meters
    }

    function checkLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
          const userLat = position.coords.latitude;
          const userLon = position.coords.longitude;

          const distance = calculateDistance(userLat, userLon, roomLat, roomLong);

          if (distance <= thresholdRadius) {
            document.getElementById('status').innerText = 
              `You are within range (${distance.toFixed(2)} meters). Now tracking attendance.`;
            
            // Send the data to server for time tracking and attendance marking
            fetch('process_location.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ userLat, userLon, status: "inside" })
            });
          } else {
            document.getElementById('status').innerText = 
              `You are out of range (${distance.toFixed(2)} meters).`;
          }
        }, error => {
          document.getElementById('status').innerText = "Error accessing location.";
        });
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }
  </script>
</body>
</html>
