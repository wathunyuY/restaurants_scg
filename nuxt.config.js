const laravelNuxt = require("laravel-nuxt");

module.exports = laravelNuxt({

    head: {
        title: 'SCG-RESTAURANT',
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: '' }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
        ]
    },
    components: true,
    modules: [
        // https://go.nuxtjs.dev/bootstrap
        'bootstrap-vue/nuxt',
        '@nuxtjs/bootstrap-vue',
        // https://go.nuxtjs.dev/axios
        '@nuxtjs/axios',
    ],
    plugins: [],
});