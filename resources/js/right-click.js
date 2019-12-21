if (navigator.userAgent.includes("Mobile") || navigator.userAgent.includes("Android") || navigator.userAgent.includes("iOS") || navigator.userAgent.includes("iPadOS") || navigator.userAgent.includes("Trident") || navigator.userAgent.includes("Firefox/5") || navigator.userAgent.includes("Firefox/4") || navigator.userAgent.includes("Firefox/3") || navigator.userAgent.includes("Firefox/2") || navigator.userAgent.includes("Firefox/1") || navigator.userAgent.includes("Chrome/5") || navigator.userAgent.includes("Chrome/4") || navigator.userAgent.includes("Chrome/3") || navigator.userAgent.includes("Chrome/2") || navigator.userAgent.includes("Chrome/1")) {} else {
    $(document).ready(function() {


        if ($("#test").addEventListener) {
          $("#test").addEventListener('contextmenu', function(e) {
            alert("You've tried to open context menu"); //here you draw your own menu
            e.preventDefault();
          }, false);
        } else {
      
          //document.getElementById("test").attachEvent('oncontextmenu', function() {
          //$(".test").bind('contextmenu', function() {
          $('body').on('contextmenu', '*', function() {
      
      
            //alert("contextmenu"+event);
            document.getElementById("rmenu").className = "show";
            document.getElementById("rmenu").style.top = mouseY(event) + 'px';
            document.getElementById("rmenu").style.left = mouseX(event) + 'px';
      
            window.event.returnValue = false;
      
      
          });
        }
      
      });
      
      // this is from another SO post...  
      $(document).bind("click", function(event) {
        $("#rmenu").fadeOut(100);
        setTimeout(() => {
          document.getElementById("rmenu").className = "hide";
          document.getElementById("rmenu").style = ""
        }, 200)
      });
      
      
      
      function mouseX(evt) {
        if (evt.pageX) {
          return evt.pageX;
        } else if (evt.clientX) {
          return evt.clientX + (document.documentElement.scrollLeft ?
            document.documentElement.scrollLeft :
            document.body.scrollLeft);
        } else {
          return null;
        }
      }
      
      function mouseY(evt) {
        if (evt.pageY) {
          return evt.pageY;
        } else if (evt.clientY) {
          return evt.clientY + (document.documentElement.scrollTop ?
            document.documentElement.scrollTop :
            document.body.scrollTop);
        } else {
          return null;
        }
      }
}