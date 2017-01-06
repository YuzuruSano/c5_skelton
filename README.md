# suiton_base_util
Base Utilities for concrete5 5.8〜

## 汎用機能クラスを随時追加できるヘルパー

/src/AdditionalUtil/Service/AdditionalUtil.phpへ追加して呼び出し

```
  $au = Core::make('helper/aUtil');
  echo $au->test();
```

※随時追加予定