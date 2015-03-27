## MODULAR BACKBONE

authors: [Rahul Lahoria](https://github.com/cap-rahul)(rahul.lahoria@capillarytech.com)

Module Structure

├── imgs
├── css
│   └── style.css
├── templates
│   ├── projects
│   │   ├── list.html
│   │   └── edit.html
│   └── users
│       ├── list.html
│       └── edit.html
├── js
│   ├── libs
│   │   ├── jquery
│   │   │   ├── jquery.min.js
│   │   ├── backbone
│   │   │   ├── backbone.min.js
│   │   └── underscore
│   │   │   ├── underscore.min.js
│   ├── models
│   │   ├── users.js
│   │   └── projects.js
│   ├── collections
│   │   ├── users.js
│   │   └── projects.js
│   ├── views
│   │   ├── projects
│   │   │   ├── list.js
│   │   │   └── edit.js
│   │   └── users
│   │       ├── list.js
│   │       └── edit.js
│   ├── router.js
│   ├── app.js
│   ├── main.js  // Bootstrap
│   ├── order.js //Require.js plugin
│   └── text.js  //Require.js plugin
└── index.html


 
