const ExtractText = require("extract-text-webpack-plugin");
const debug = process.env.NODE_ENV !== "production";
const webpack = require("webpack");

const extractEditorSCSS = new ExtractText({
  filename: "./blocks.editor.build.css",
});
const extractBlockSCSS = new ExtractText({
  filename: "./blocks.style.build.css",
});

const plugins = [extractEditorSCSS, extractBlockSCSS];
const scssConfig = {
  use: [
    {
      loader: "css-loader",
    },
    {
      loader: "sass-loader",
      options: {
        sassOptions: {
          outputStyle: "compressed",
        },
      },
    },
  ],
};

module.exports = {
  context: __dirname,
  devtool: debug ? "inline-sourcemap" : null,
  mode: debug ? "development" : "production",
  entry: "./blocks/src/blocks.js",
  output: {
    path: __dirname + "/blocks/dist/",
    filename: "blocks.build.js",
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: "babel-loader",
          },
        ],
      },
      {
        test: /editor\.scss$/,
        exclude: /node_modules/,
        use: extractEditorSCSS.extract(scssConfig),
      },
      {
        test: /style\.scss$/,
        exclude: /node_modules/,
        use: extractBlockSCSS.extract(scssConfig),
      },
    ],
  },
  plugins: plugins,
};
