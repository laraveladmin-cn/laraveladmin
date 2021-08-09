<?php 
$str = <<<'str'
{
    "Compile and generate the front-end entry file \"index.html\"": "フロントエンドの入り口ファイルをコンパイルします。index.",
    "Execute all migration files": "すべてのファイルを実行します。",
    "Is the \":file\" file already overwritten?": "ファイル“:file”は既に存在しますか？上書きしますか？y|N",
    "The \":file\" file already exists": "ファイル\":file\"は既に存在します。",
    "File \":file\" created successfully": "ファイル\":file\"の作成に成功しました。",
    "Failed to create file \":file\"": "ファイル\":file\"の作成に失敗しました。",
    "Generate all resources": "すべてのリソースを生成",
    "Custom template controller generation": "カスタムテンプレートコントローラの生成",
    "Created At": "作成時間",
    "Updated At": "変更時間",
    "Deleted At": "削除時間",
    "Custom template model generation": "カスタムテンプレートの生成",
    "Custom template data fill file generation": "カスタムテンプレートデータの塗りつぶしファイルの生成",
    "Custom template front-end view generation": "カスタムテンプレートのフロントエンドビューの生成",
    "The application language is not set to English to execute": "アプリケーションの言語は英語に設定されていない場合のみ実行できます。",
    "From \":old\" to \":new\"": "「：old」から「new」へ",
    "Failed to translate \":old\"": "翻訳“:old”が失敗しました",
    "Failed to translate \":old\" into \":lang\"": "翻訳「old」は「lang」に失敗しました。",
    "This command can only be executed in the development environment": "このコマンドは開発環境でのみ実行できます。",
    "Automatic scan to generate Api document data": "自動スキャンでApi文書データを生成します。"
}
str;
return json_decode($str,true);