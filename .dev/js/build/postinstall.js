const fs = require('fs');
const path = require('path');
const path_base = path.dirname(path.dirname(path.dirname(path.resolve(__dirname))));

/**
 * Copy file from bootstrap repo upon installation.
 * @param bootstrap_path    Bootstrap relative path.
 * @param theme_path        Theme relative path.
 * @param replaceStrings    Replace string in target file.
 */
const copyFromBootstrap = (bootstrap_path, theme_path, replaceStrings = [])=>{

    // If we can copy variables from Bootstrap, do it
    let src_path = path_base+'/node_modules/bootstrap/'+bootstrap_path;
    let dest_path = path_base+'/.dev/'+theme_path;
    let filename = path.basename(theme_path);

    // Copy file from Bootstrap repository if it does not exist
    if (fs.existsSync(dest_path)) {
        console.info("\x1b[32m", 'The '+filename+' file already exists in this template.');
    } else if (fs.existsSync(src_path)) {
        fs.copyFile(src_path, dest_path, (err) => {
            if (err) {
                console.error("\x1b[31m", 'Unable to copy '+filename+' file from Bootstrap package to template!');
                throw err;
            } else {
                console.info("\x1b[32m", 'Copy '+filename+' from Bootstrap package to template.')

                // Replace strings
                if( Object.keys(replaceStrings).length ) {

                    /**
                     * @type {string} buffer
                     */
                    let buffer = fs.readFileSync(dest_path).toString();
                    for( let replaceFrom in replaceStrings ) {
                        if (replaceStrings.hasOwnProperty(replaceFrom)) {
                            buffer = buffer.replace(new RegExp(replaceFrom, 'g'), replaceStrings[replaceFrom]);
                        }
                    }

                    fs.writeFileSync(dest_path, buffer);
                }
            }
        });
    } else {
        console.error("\x1b[31m", 'Unable to locate Bootstrap package in ./node_modules');
    }
}

// If we can copy variables from Bootstrap, do it
copyFromBootstrap(
    'scss/_variables.scss',
    'scss/_variables.scss',
);
copyFromBootstrap(
    'scss/_variables-dark.scss',
    'scss/_variables-dark.scss',
);
copyFromBootstrap(
    'scss/bootstrap.scss',
    'scss/_bootstrap.scss',
    {
        '@import "' : '@import "~bootstrap/scss/'
    }
);

// Create /assets directory if it does not exist
let assets_path = path_base+'/assets/build';
if (fs.existsSync(assets_path)) {
    console.info("\x1b[32m", 'The /assets/build directory already exists in this template.');
} else {
    fs.mkdirSync(assets_path, { recursive: true }, (err) => {
        if (err) {
            console.error("\x1b[31m", 'Unable to create /assets/build directory!');
            throw err;
        } else {
            console.info("\x1b[32m", 'Created /assets/build directory.')
        }
    });
}

// Reset console styling
console.log("\x1b[0m");