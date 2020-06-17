var Encore = require('@symfony/webpack-encore');

Encore

    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .addEntry('js/app', [
        './assets/bootstrap/dist/js/bootstrap.min.js',
        './assets/js/app.js'
    ])
    .addStyleEntry('css/app', [
        './assets/bootstrap/dist/css/bootstrap.min.css',
        './assets/css/app.css'
    ])
	
module.exports = Encore.getWebpackConfig();