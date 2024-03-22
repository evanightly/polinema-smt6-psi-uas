// vite.config.js
import { defineConfig } from "file:///D:/Software/laragon/www/polinema-smt6-psi-uas/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Software/laragon/www/polinema-smt6-psi-uas/node_modules/laravel-vite-plugin/dist/index.js";
import { svelte } from "file:///D:/Software/laragon/www/polinema-smt6-psi-uas/node_modules/@sveltejs/vite-plugin-svelte/src/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    svelte()
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxTb2Z0d2FyZVxcXFxsYXJhZ29uXFxcXHd3d1xcXFxwb2xpbmVtYS1zbXQ2LXBzaS11YXNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXFNvZnR3YXJlXFxcXGxhcmFnb25cXFxcd3d3XFxcXHBvbGluZW1hLXNtdDYtcHNpLXVhc1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovU29mdHdhcmUvbGFyYWdvbi93d3cvcG9saW5lbWEtc210Ni1wc2ktdWFzL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5pbXBvcnQgeyBzdmVsdGUgfSBmcm9tIFwiQHN2ZWx0ZWpzL3ZpdGUtcGx1Z2luLXN2ZWx0ZVwiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogW1wicmVzb3VyY2VzL2Nzcy9hcHAuY3NzXCIsIFwicmVzb3VyY2VzL2pzL2FwcC5qc1wiXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgIH0pLFxuICAgICAgICBzdmVsdGUoKSxcbiAgICBdLFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQW1VLFNBQVMsb0JBQW9CO0FBQ2hXLE9BQU8sYUFBYTtBQUNwQixTQUFTLGNBQWM7QUFFdkIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxPQUFPO0FBQUEsRUFDWDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==