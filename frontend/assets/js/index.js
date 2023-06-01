function initMap() {
    const myLatLngJkpg = { lat: 57.781269, lng: 14.171196, };
    const myLatLngSthlm = { lat: 59.335669, lng: 18.064831, };
    const myLatLngGbg = { lat: 57.704370, lng: 11.965398, };



    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: { lat: 58.446687, lng: 14.882879, },
    });
    

    
    new google.maps.Marker({
        position: myLatLngJkpg,
        map,
        title: "Jönköping!",
      });

    new google.maps.Marker({
      position: myLatLngSthlm,
      map,
      title: "Stockholm!",
    });

    new google.maps.Marker({
        position: myLatLngGbg,
        map,
        title: "Göteborg!",
      });
  }
  
  window.initMap = initMap;
