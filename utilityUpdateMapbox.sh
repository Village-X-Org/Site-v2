php getVillages.php
php getProjects.php

curl --request PATCH "https://api.mapbox.com/datasets/v1/jdepree/cj7c0nlxf0yko33o7uz9pogof?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA" \
  -d https://4and.me/cached/villages.json
curl --request PATCH "https://api.mapbox.com/datasets/v1/jdepree/cj7c0n3dl0ykf33o73m0pv5u6?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA" \
  -d https://4and.me/cached/projects.json
