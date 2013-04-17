(function() {
   tinymce.create('tinymce.plugins.sharebuttons', {
      init : function(ed, url) {
         ed.addButton('sharebuttons', {
            title : 'Share Button',
            image : url+'/sharebuttons.png',
            onclick : function() {
                ed.execCommand('mceInsertContent', false, '[shareB]');
                  
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Share Buttons",
            author : 'Gadgets Choose',
            authorurl : 'http://www.gadgets-code.com',
            infourl : 'http://www.gadgets-code.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('sharebuttons', tinymce.plugins.sharebuttons);
})();