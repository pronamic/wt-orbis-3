module.exports = function( grunt ) {
	require( 'load-grunt-tasks' )( grunt );

	var phpFiles = [
		'**/*.php',
		'!node_modules/**',
		'!bower_components/**',
		'!deploy/**',
		'!vendor/**'
	];

	// Project configuration.
	grunt.initConfig( {
		// Package
		pkg: grunt.file.readJSON( 'package.json' ),
		
		// PHPLint
		phplint: {
			all: phpFiles
		},
		
		// Check textdomain errors
		checktextdomain: {
			options:{
				text_domain: 'orbis',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src: phpFiles,
				expand: true
			}
		},
		
		// Make POT
		makepot: {
			target: {
				options: {
					domainPath: 'languages',
					type: 'wp-theme',
					updatePoFiles: true,
					exclude: [
						'bower_components/.*',
						'node_modules/.*'
					]
				}
			}
		},

		// PHP Code Sniffer
		phpcs: {
			application: {
				src: phpFiles
			},
			options: {
				bin: 'vendor/bin/phpcs',
				standard: 'phpcs.ruleset.xml',
				showSniffCodes: true
			}
		},

		// Copy
		copy: {
			theme_style: {
				files: [
					{ // Theme CSS
						expand: true,
						cwd: 'src/css/',
						src: [ '**' ],
						dest: 'css'
					},
				]
			},
			assets: {
				files: [
					{ // Bootstrap
						expand: true,
						cwd: 'node_modules/bootstrap/dist/',
						src: [ '**' ],
						dest: 'assets/bootstrap'
					},
					{ // Font Awesome - http://fontawesome.io/
						expand: true,
						cwd: 'node_modules/@fortawesome/fontawesome-free',
						src: [ 'css/**', 'webfonts/**' ],
						dest: 'assets/fontawesome'
					},
					{ // Tether - http://tether.io/
						expand: true,
						cwd: 'node_modules/tether/dist/',
						src: [ '**' ],
						dest: 'assets/tether'
					},
					{ // Popper.js - https://popper.js.org/
						expand: true,
						cwd: 'node_modules/popper.js/dist/umd',
						src: [ '**' ],
						dest: 'assets/popper'
					},
				]
			},

			deploy: {
				src: [
					'**',
					'!bower.json',
					'!composer.json',
					'!composer.lock',
					'!Gruntfile.js',
					'!package.json',
					'!phpunit.xml',
					'!phpunit.xml.dist',
					'!phpcs.ruleset.xml',
					'!CHANGELOG.md',
					'!README.md',
					'!bower_components/**',
					'!deploy/**',
					'!node_modules/**',
					'!src/**',
					'!trash/**',
				],
				dest: 'deploy/latest',
				expand: true
			},
		},

		// Clean
		clean: {
			build: {
				src: [
					'assets',
					'css',
					'images',
					'js',
					'screenshot.png'
				]
			},

			deploy: {
				src: [ 'deploy/latest' ]
			},
		},

		// Compress
		compress: {
			deploy: {
				options: {
					archive: 'deploy/archives/<%= pkg.name %>.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'deploy/latest',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		},

		// Git checkout
		gitcheckout: {
			tag: {
				options: {
					branch: 'tags/<%= pkg.version %>'
				}
			},
			develop: {
				options: {
					branch: 'develop'
				}
			}
		},

		// S3
		aws_s3: {
			options: {
				region: 'eu-central-1'
			},
			deploy: {
				options: {
					bucket: 'downloads.pronamic.eu',
					differential: true
				},
				files: [
					{
						expand: true,
						cwd: 'deploy/archives/',
						src: '<%= pkg.name %>.<%= pkg.version %>.zip',
						dest: 'themes/<%= pkg.name %>/'
					}
				]
			}
		},

		// SASS
		sass: {
			build: {
				files: {
					'src/css/style.css': 'src/sass/style.scss'
				}
			}
		},

		// Concat
		concat: {
			js: {
				src: [ 'src/js/script.js' ],
				dest: 'assets/orbis/js/script.js'
			}
		},

		// CSS min
		cssmin: {
			combine: {
				files: {
					'css/editor-style.min.css': 'css/editor-style.css',
					'css/style.min.css': 'css/style.css'
				}
			}
		},
		
		// Uglify
		uglify: {
			combine: {
				files: {
					'assets/orbis/js/script.min.js': [ 'assets/orbis/js/script.js' ]
				}
			}
		},

		// Image min
		imagemin: {
			build: {
				files: [
					{ // Orbis
						expand: true,
						cwd: 'src/images',
						src: [ '**/*.{png,jpg,gif}' ],
						dest: 'assets/orbis/images'
					}
				]
			},

			theme: {
				files: {
					'screenshot.png': 'src/screenshot.png'
				}
			}
		}
	} );

	// Default task(s).
	grunt.registerTask( 'default', [
		'clean',
		'phplint',
		'concat',
		'sass',
		'cssmin',
		'copy',
		'uglify',
		'imagemin'
	] );

	grunt.registerTask( 'pot', [
		'checktextdomain',
		'makepot'
	] );

	grunt.registerTask( 'deploy', [
		'default',
		'build',
		'clean:deploy',
		'copy:deploy',
		'compress:deploy'
	] );
	
	grunt.registerTask( 's3-deploy', [
		'gitcheckout:tag',
		'deploy',
		'aws_s3:deploy',
		'gitcheckout:develop'
	] );
};
