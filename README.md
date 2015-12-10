# suiton_base_util
Base Utilities for concrete5 5.7〜

## デフォルトmeta description と meta keyword登録機能
meta keyword都市伝説を信じる紳士淑女のためにデフォルト入力欄を設置。

各ページにdescriptionとkeywordの設定がない場合は/dashboard/system/basics/nameで設定の内容が反映

## 汎用機能クラスを随時追加できるヘルパー

/src/AdditionalUtil/Service/AdditionalUtil.phpへ追加して呼び出し

```
  $au = Core::make('helper/aUtil');
  echo $au->test();
```

※随時追加予定