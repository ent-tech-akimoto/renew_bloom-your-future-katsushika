(function () {
  tinymce.create("tinymce.plugins.SponsorsButtons", {
    init: function (editor, url) {
      // ブロックボタン
      editor.addButton("sponsors_block_btn", {
        text: "ブロック",
        icon: false,
        onclick: function () {
          var shortcode =
            '[sponsors_block title="ここに見出し"]\n' +
            "ここに本文を入力してください\n" +
            "[/sponsors_block]\n\n";

          editor.insertContent(shortcode);
        },
      });
      // お問い合わせブロックボタン
      editor.addButton("sponsors_contact_btn", {
        text: "お問い合わせブロック",
        icon: false,
        onclick: function () {
          var shortcode =
            '[sponsors_contact url="ここにURLを入力してください" label="お問い合わせはこちら"]\n\n';

          editor.insertContent(shortcode);
        },
      });
    },
  });
  tinymce.PluginManager.add(
    "sponsors_buttons",
    tinymce.plugins.SponsorsButtons
  );
})();