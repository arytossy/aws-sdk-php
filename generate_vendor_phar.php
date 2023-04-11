<?php

function logging($message)
{
    echo $message . PHP_EOL;
}

// phar ファイル名
$phar_file = __DIR__ . "/src/vendor.phar";

// 成果物(tar を gzip で圧縮した形式の phar を作成する)
$archive = $phar_file . ".tar.gz";

// 元となるファイル群(composer によってインストールされたパッケージたち)
$src = __DIR__ . "/vendor";

// 元となるファイル群の存在チェック
if (!file_exists($src)) {
    logging("composer でパッケージをインストールしてから実行してください。");
    exit(1);
}

// phar の作成ができるかどうか
if (!Phar::canWrite()) {
    logging("php.ini の phar.readonly を 0 にするか、オプション -d phar.readonly=0 を付けて実行してください。");
    exit(1);
}

// 成果物の存在チェック
if (file_exists($archive)) {
    if (key_exists("f", getopt("f"))) {
        logging("古い phar を削除します: $archive");
        unlink($archive);
    } else {
        logging("既に phar が存在しています。削除してから実行するか、オプション -f を付けて実行してください。");
        logging("    既に存在するファイル: $archive");
        exit(1);
    }
}

// phar の作成
logging("phar を作成します...");
logging("    ソース: $src");
logging("    成果物: $archive");
$phar = new Phar($phar_file, 0);
$phar = $phar->convertToExecutable(Phar::TAR, Phar::GZ);
$phar->startBuffering();
$phar->buildFromDirectory($src);
$phar->stopBuffering();
logging("... phar の作成が完了しました: $archive");
