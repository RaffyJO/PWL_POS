<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        // dump($request->berkas);
        // dump($request->file('file'));
        // return "Pemrosesan file upload di sini";

        // if ($request->hasFile('berkas')) {
        //     echo "path(): " . $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): " . $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): " . $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): " . $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): " . $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): " . $request->berkas->getSize();
        // } else {
        //     echo "Tidak ada berkas yang diupload";
        // }

        // $path = $request->berkas->store('uploads');
        // $path = $request->berkas->storeAs('uploads', 'berkas');
        // $namaFile = $request->berkas->getClientOriginalName();
        // $extfile = $request->berkas->getClientOriginalName();
        // $namaFile = 'web-' . time() . "." . $extfile;
        // $path = $request->berkas->storeAs('public', $namaFile);

        // $pathBaru = asset('storage/' . $namaFile);
        // echo "Proses upload berhasil, data disimpan pada: $path";
        // echo "<br>";
        // echo "Tampilkan link:<a href='$pathBaru'>$pathBaru";
        // echo $request->berkas->getClientOriginalName() . " Lolos validasi";

        $request->validate([
            'berkas' => 'required|file|image|max:5000',
            'name_file' => 'required',
        ]);

        $extfile = $request->berkas->getClientOriginalExtension();
        // $namaFile = 'web-' . time() . "." . $extfile;
        $namaFile = $request->name_file . '.' . $extfile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\", "//", $path);
        // echo "Variabel path berisi:$path <br>";

        $pathBaru = asset('gambar/' . $namaFile);
        // echo "proses upload berhasil, data disimpan pada: $path";
        // echo "<br>";
        // echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        echo "Gambar berhasil diupload ke <a href='$pathBaru'>$namaFile</a>";
        echo "<br>";
        echo "<img src='$pathBaru' alt='Uploaded Image' width='200' height='200'>";
    }
}
