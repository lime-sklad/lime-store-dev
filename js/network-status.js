$(document).ready(function () {
    // network connection tester by Sadi Mammadov
    const checkOnlineStatus = async () => {
        try {
            const online = await fetch("https://jsonplaceholder.typicode.com/todos/1");
          return online.status >= 200 && online.status < 300; // either true or false
        } catch (err) {
          return false; // if offline
        }
      }


    setInterval(async () => {
        const result = await checkOnlineStatus();
         
        
        if (result) {
         
            $('.network-container').css('background-color', "green");
            $('.network-container').attr('title', 'Internet bağlantısı normaldır.');

            
        }else{
            
            $('.network-container').css('background-color', "red");
            $('.network-container').attr('title', 'Internet bağlantısı yoxdur.');
            
        }
      }, 15000);
});