# ASSET MINIFYER

## Description
Simple library in order to minify js and css files used as assets into web projects 

## How to use

### Directly to driver
```
use JuanchoSL\AssetMinifyer\Drivers\JSMin;

$minifyed_content = JSMin::minify($js_code);
```
or
```
use JuanchoSL\AssetMinifyer\Drivers\CSSMin;

$minifyed_content = CSSMin::minify($css_code);
```

### Use Adapter for contents
```
use JuanchoSL\AssetMinifyer\Adapters\Minifyer;

$minifyer = new Minifyer();
$js_minifyed = $minifyer->cleanJs($js_code);
$css_minifyed = $minifyer->cleanCss($css_code);
```

### Use Adapter for some files 
The files contents will minifyed and concatenated. Do not use for distinct file types.
```
use JuanchoSL\AssetMinifyer\Adapters\Minifyer;

$minifyer = new Minifyer();
$minifyer->addFiles([$asset_fullpath_1, $asset_fullpath_2]);
$asset_minifyed = $minifyer->getContent();

```