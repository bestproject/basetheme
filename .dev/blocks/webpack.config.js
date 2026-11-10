// const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

import defaultConfig from '@wordpress/scripts/config/webpack.config.js';

export default {
    ...defaultConfig,
    module: {
        ...defaultConfig.module,
    },
};