module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es6: true,
    jquery: true,
  },
  parserOptions: {
    requireConfigFile: false,
    parser: '@babel/eslint-parser',
  },
  plugins: [
    'import',
  ],
  extends: [
    'prestashop',
  ],
  rules: {
    'no-new': 0,
    'class-methods-use-this': 0,
    'no-alert': 0,
  },
};
