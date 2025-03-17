<script>
   function title(title) {
      document.title = title;
   }

   function link(href) {
      var link = document.createElement('link');

      link.rel = 'stylesheet';
      link.type = 'text/css';
      link.href = href;

      document.head.appendChild(link);
   }

   function script(src) {
      var script = document.createElement('script');

      script.src = src;
      script.type = 'text/javascript';

      document.documentElement.appendChild(script);
   }
</script>