{{-- Appliquer le thème avant le paint (évite le flash) — placer juste après <head> ou les meta --}}
<script>
(() => {
  const KEY = 'nexshop-theme';
  const root = document.documentElement;
  const saved = localStorage.getItem(KEY);
  const theme = saved === 'light' || saved === 'dark' ? saved : 'dark';
  root.setAttribute('data-theme', theme);
})();
</script>
