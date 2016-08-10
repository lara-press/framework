var webpack = require('webpack');
var ExtractPlugin = require('extract-text-webpack-plugin');
var AssetsPlugin = require('assets-webpack-plugin');
var CleanPlugin = require('clean-webpack-plugin');

var path = require('path');

var isProduction = function () {
  return process.env.NODE_ENV === 'production';
};

var config = {
  target: 'web',
  context: path.join(path.resolve(__dirname), '/resources/assets'),
  entry: {
    app: [
      'babel-polyfill',
      './scss/app.scss',
      'webpack-dev-server/client?http://localhost:3000',
      'webpack/hot/dev-server',
      './js/index',
    ],
    vendor: ['jquery']
  },
  output: {
    path: path.join(path.resolve(__dirname), '/public/dist'),
    filename: 'js/[name]' + (isProduction() ? '-[hash:7]' : '') + '.js',
    chunkFilename: 'js/[name]-[chunkhash:7].js',
    publicPath: 'http://localhost:3000/dist/',
  },
  debug: !isProduction(),
  devtool: isProduction() ? false : 'source-map',
  module: {
    loaders: [
      {
        loader: "babel-loader",

        // Skip any files outside of your project's `src` directory
        include: [
          path.join(path.resolve(__dirname), "resources/assets/js"),
        ],

        // Only run `.js` and `.jsx` files through Babel
        test: /\.jsx?$/,

        // Options to configure babel with
        query: {
          plugins: ['transform-runtime'],
          presets: ['es2015', 'stage-0', 'react'],
        }
      },
      {
        test: /\.scss$/,
        loader: isProduction() ? ExtractPlugin.extract('style', 'css!sass?sourceMap') : 'style!css!sass?sourceMap',
      },
      {
        test: /\.(png|gif|jpe?g|svg)$/i,
        loaders: [
          'url?limit=10000&name=img/[name]-[hash:7].[ext]', // Inline base64 URLs for <= 10k images, direct URLs for others
          'image-webpack?{bypassOnDebug: true, progressive:true, optimizationLevel: 7, interlaced: false, pngquant:{quality: "65-90", speed: 4}}'
        ]
      },
    ],
  },

  resolve: {
    extensions: ['', '.js', '.jsx', '.scss', '.sass', '.css'],
    modulesDirectories: [
      'node_modules',
    ],
  },

  devServer: {
    contentBase: './dist',
  },

  plugins: [
    new CleanPlugin('public/dist'),
    new ExtractPlugin('css/[name]' + (isProduction() ? '-[hash:7]' : '') + '.css'),

    // Map $ and jQuery to `require('jquery')`
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery'
    }),

    // Analyzes chunks for recurring dependencies, and extracts them somewhere else
    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor', // The commons chunk name
      filename: 'vendor.js', // The filename of the commons chunk
      minChunks: Infinity, // (with more entries, this ensures that no other module goes into the vendor chunk)
      chunks: ['app'] // Only use these entries
    }),

    // Create a manifest file
    new AssetsPlugin({
      path: path.resolve('public/dist'),
      filename: 'manifest.json',
      prettyPrint: true
    }),

    // NoErrorsPlugin is a little plugin used when running webpack-dev-server
    // just to make sure it doesn't refresh your browser if your
    // latest change throws an error when rebuilding.
    new webpack.NoErrorsPlugin(),

    // This plugins defines various variables that we can set to false
    // in production to avoid code related to them from being compiled
    // in our final bundle
    new webpack.DefinePlugin({
      __DEBUG__: !isProduction(),
      'process.env': {
        BABEL_ENV: JSON.stringify(isProduction() ? 'production' : 'local'),
        NODE_ENV: JSON.stringify(isProduction() ? 'production' : 'local')
      }
    }),

    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin(),
  ]
};

// Production plugins
if (isProduction()) {
  config.plugins = config.plugins.concat([
    // This plugin looks for similar chunks and files
    // and merges them for better caching by the user
    new webpack.optimize.DedupePlugin(),

    // This plugins optimizes chunks and modules by
    // how much they are used in your app
    new webpack.optimize.OccurenceOrderPlugin(),

    // This plugin prevents Webpack from creating chunks
    // that would be too small to be worth loading separately
    new webpack.optimize.MinChunkSizePlugin({
      minChunkSize: 51200 // ~50kb
    }),

    // This plugin minifies all the Javascript code of the final bundle
    // Will also minimize css files :D
    new webpack.optimize.UglifyJsPlugin({
      mangle: true,
      compress: {
        warnings: false
      } // Suppress uglification warnings
    }),

    // Add banner
    new webpack.BannerPlugin([
      'Author: PortOneFive <support@portonefive.com>',
      'Date: ' + new Date().toLocaleDateString('nl-NL')
    ].join("\n"), { raw: false, entryOnly: true })
  ]);
}

// Exports
module.exports = config;
