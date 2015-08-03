'use strict';
var lrSnippet = require('grunt-contrib-livereload/lib/utils').livereloadSnippet;
var mountFolder = function (connect, dir) {
    return connect.static(require('path').resolve(dir));
};

module.exports = function (grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    // configurable paths
    var projectConfig = {
        app: 'app',
        dist: 'dist'
    };
    // Project configuration.
    grunt.initConfig({
        project: projectConfig,
        watch: {
            livereload: {
                files: [
                    '<%= project.app %>/{,*/}*.html',
                    '{.tmp,<%= project.app %>}/css/{,*/}*.css',
                    '{.tmp,<%= project.app %>}/scripts/{,*/}*.js',
                    '<%= project.app %>/img/{,*/}*.{png,jpg,jpeg,gif,webp,svg}'
                ],
                tasks: ['livereload', 'compass']

            }
        },
        connect: {
            options: {
                port: 9000,
                // Change this to '0.0.0.0' to access the server from outside.
                hostname: 'localhost'
            },
            livereload: {
                options: {
                    middleware: function (connect) {
                        return [
                            lrSnippet,
                            mountFolder(connect, '.tmp'),
                            mountFolder(connect, projectConfig.app)
                        ];
                    }
                }
            },
            test: {
                options: {
                    middleware: function (connect) {
                        return [
                            mountFolder(connect, '.tmp'),
                            mountFolder(connect, 'test')
                        ];
                    }
                }
            }
        },
        open: {
            server: {
                url: 'http://localhost:<%= connect.options.port %>'
            }
        },
        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '.tmp',
                        '<%= project.dist %>/*',
                        '!<%= project.dist %>/.git*'
                    ]
                }]
            },
            server: '.tmp'
        },
        jshint: {
            all: [
                'Gruntfile.js',
                '<%= project.app %>/scripts/{,*/}*.js'
            ],
            options: {
                jshintrc: '.jshintrc'
            }
        },
        concat: {
            dist: {
                files: {
                    '<%= project.dist %>/scripts/scripts.js': [
                        '.tmp/js/{,*/}*.js',
                        '<%= project.app %>/scripts/{,*/}*.js',
                        '<%= project.app %>/partials/**/*.js'
                    ]
                }
            }
        },
        useminPrepare: {
            html: '<%= project.app %>/**/*.html',
            options: {
                dest: '<%= project.dist %>'
            }
        },
        usemin: {
            html: ['<%= project.dist %>/**/*.html'],
            css: ['<%= project.dist %>/**/*.css'],
            options: {
                basedir: '<%= project.dist %>',
                dirs: ['<%= project.dist %>']
            }
        },
        imagemin: {
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= project.app %>/img',
                        src: '{,*/}*.{png,jpg,jpeg}',
                        dest: '<%= project.dist %>/img'
                    }
                ]
            }
        },
        cssmin: {
            dist: {
                options: {
                    report: 'min'
                },
                files: {
                    '<%= project.dist %>/css/app.css': [
                        '<%= project.app %>/css/app.css'
                    ]
                }
            }
        },
        htmlmin: {
            dist: {
                options: {
                },
                files: [{
                    expand: true,
                    cwd: '<%= project.app %>',
                    src: [
                        '*.html',
                        'partials/**/*.html'
                    ],
                    dest: '<%= project.dist %>'
                }]
            }
        },
        cdnify: {
            dist: {
                html: ['<%= project.dist %>/*.html']
            }
        },
        ngmin: {

            controllers: {
                src: ['<%= project.dist %>/js/scripts.js'],
                dest: '<%= project.dist %>/scripts/scripts.js'
            }
        },
        uglify: {
            options: {
                report: 'min'
            },
            dist: {
                files: {
                    '<%= project.dist %>/scripts/scripts.js': ['<%= project.dist %>/scripts/scripts.js']
                }
            }
        },
        rev: {
            dist: {
                files: {
                    src: [
                        '<%= project.dist %>/scripts{,*/}*.js',
                        '<%= project.dist %>/styles/**/*.css',
                        '<%= project.dist %>/img/**/*.{png,jpg,jpeg,gif,webp,svg}',
                        '<%= project.dist %>/css/*'
                    ]
                }
            }
        },
        copy: {
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= project.app %>',
                    dest: '<%= project.dist %>',
                    src: [
                        '*.{ico,txt,png}',
                        '.htaccess',
                        'lib/**/*',
                        'img/{,*/}*.{gif,webp}',
                        'partials/**/*',
                        'css/*'
                    ]
                }]
            }
        }
    });

    grunt.registerTask('server', [
        'clean:server',
        'livereload-start',
        'connect:livereload',
        'open',
        'watch'
    ]);
    grunt.registerTask('build', [
        'clean:dist',
        'jshint',
        'useminPrepare',
        'imagemin',
        'cssmin',
        'htmlmin',
        'concat',
        'copy',
        'cdnify',
        'ngmin',
        'uglify',
        'rev',
        'usemin'

    ]);


    grunt.registerTask('default', ['build']);

};