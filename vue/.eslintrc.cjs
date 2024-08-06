/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution");

module.exports = {
  root: true,
  extends: [
    "plugin:vue/vue3-essential",
    "eslint:recommended",
    "@vue/eslint-config-typescript",
    "@vue/eslint-config-prettier",
  ],
  parserOptions: {
    ecmaVersion: "latest",
  },
  rules: {
      "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
      "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
      "vue/no-deprecated-slot-attribute": "off",
      "@typescript-eslint/no-this-alias": 0,
      "prettier/prettier": 0,
      // "prettier/prettier": [
      //     "error",
      //     {
      //         endOfLine: "auto",
      //     },
      // ],
  },
};
