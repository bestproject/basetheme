const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    output: {
        ...defaultConfig.output,
        iife: true,
    },
    optimization: {
        ...defaultConfig.optimization,
        avoidEntryIife: false,
    },
    module: {
        ...defaultConfig.module,
    },
};
