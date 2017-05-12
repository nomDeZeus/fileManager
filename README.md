# fileManager
Permet de remplir un input de type "text" avec l'url d'un fichier, d'ajouter des fichiers et de gérer une arborescence.
## Installation
Inclure Jquery
```html
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
```
Inclure Le JS et le CSS de FancyBox
```html
<link rel="stylesheet" href="uploader/fancybox/source/jquery.fancybox.css">
<script type="text/javascript" src="uploader/fancybox/source/jquery.fancybox.pack.js"></script>
```
Inclure le script du file manager
```html
<script type="text/javascript" src="uploader/js/uploader.js"></script>
```
## Configuration
### Répertoire d'upload
Modifier la ligne suivante du fichier uploader.json:
```json
"upload_dir": "uploads",
```
Le chemin du répertoire est donné par rapport au répertoire 'uploader'.

**Penser à donner les droits sur le fichier d'upload à l'utilisateur qui exécute PHP** (par exemple www-data).

### Taille maximum par upload
Modifier la ligne suivante du fichier uploader.json:
```json
"max_upload_size": 2097152
```
La taille est donnée en octets **et doit être inférieure à celle indiquée dans le php.ini**.
### Lancer le file manager
Donner les paramètres de la fancybox
```javascript
$("#button").fancybox({
        'fitToView'         : false,
        'width'             : '75%',
        'height'            : '80%',
        'autoScale'         : false,
        'autoSize'          : false,
        'transitionIn'      : 'elastic',
        'transitionOut'     : 'elastic',
        'type'              : 'iframe'
    });
```
Lien associé au JavaScript ci-dessus:
```html
<a id="button" href="uploader/fancybox.php?iframe">Open iframe</a>
```
#### Spécifier l'id de l'input à remplir
```javascript
var uploader = new Uploader("image");
```
