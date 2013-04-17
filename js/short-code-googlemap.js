(function() {
   tinymce.create('tinymce.plugins.googlemaps', {
      init : function(ed, url) {
         ed.addButton('googlemaps', {
            title : 'Google Map',
            image : url+'/googlemap.png',
            onclick : function() {
                var address = prompt("Map Location", "NY, USA");
                var note = prompt("Enter Text", "Hello");
                var mapid = prompt("Provide unique ID for this map", "new");
                var zoom = prompt("Zoom Level", "13");
                var width = prompt("Width of the Map", "300");
                var height = prompt("Height of the Map", "300");
                ed.execCommand('mceInsertContent', false, '[googleMAP address="' + address + '" note="' + note + '" mapid="' + mapid +'" zoom="' + zoom + '" width="' + width +'" height="' + height +'"]');                 
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Google Map",
            author : 'Gadgets Choose',
            authorurl : 'http://www.gadgets-code.com',
            infourl : 'http://www.gadgets-code.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('googlemaps', tinymce.plugins.googlemaps);
})();