# JetBrains Plugin Data Badges

Displays Badges for JetBrains Plugins.

## Installation

```
composer create-project cedricziel/jetbrains-plugin-badges badges
cd badges
php -S 127.0.0.1:8000 -t web
```

**Download Count** http(s)://{host}/plugin/{pluginId}/downloads/svg

The result can be embedded as follows:

```
![alt-text](http(s)://{host}/plugin/{pluginId}/downloads/svg)
```

# License

MIT
