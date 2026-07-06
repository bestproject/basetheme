/** @type {import('stylelint').Config} */
module.exports = {
  extends: [
    "stylelint-config-sass-guidelines",
    "stylelint-scss",
  ],
  rules: {
    "block-no-empty": true,
    "max-nesting-depth": 5,
    "selector-no-qualifying-type": false,
    "selector-class-pattern": null,
  },
  overrides: [
    {
      files: ".dev/**/*.scss"
    }
  ]
};