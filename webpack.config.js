var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

var path = require('path');

module.exports = {
  context: path.join(path.resolve(__dirname), '/resources/assets'),
  entry: [
    'webpack-dev-server/client?http://localhost:3000',
    'webpack/hot/only-dev-server',
    './js/app.js',
  ],
  output: {
    path: path.join(path.resolve(__dirname), '/dist'),
    filename: "bundle.js",
    publicPath: 'http://localhost:3000/dist/'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader',
      },
      {
        test: /\.scss$/,
        include: /resources\/assets\/scss/,
        loader: 'style!css!sass',
      },
    ],
  },

  resolve: {
    extensions: ['', '.js', '.jsx', '.scss', '.sass', '.css']
  },

  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin(),
    new ExtractTextPlugin('public/dist/app.css', {
      allChunks: true
    })
  ]
};
