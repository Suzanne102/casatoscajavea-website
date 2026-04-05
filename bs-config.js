module.exports = {
  server: {
    baseDir: "public"
  },
  files: [
    "public/**/*.html",
    "public/css/**/*.css",
    "public/js/**/*.js",
    "public/templates/**/*.html"
  ],
  watchOptions: {
    ignoreInitial: true,
    awaitWriteFinish: {
      stabilityThreshold: 500,
      pollInterval: 100
    }
  },
  injectChanges: false,
  notify: false,
  open: true,
  port: 3000
};