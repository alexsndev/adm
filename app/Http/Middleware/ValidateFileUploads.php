<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFileUploads
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasFile('file') || $request->hasFile('image')) {
            $files = $request->allFiles();
            
            foreach ($files as $file) {
                if (is_array($file)) {
                    foreach ($file as $singleFile) {
                        if (!$this->isValidFile($singleFile)) {
                            return response()->json([
                                'error' => 'Arquivo inválido ou não permitido'
                            ], 400);
                        }
                    }
                } else {
                    if (!$this->isValidFile($file)) {
                        return response()->json([
                            'error' => 'Arquivo inválido ou não permitido'
                        ], 400);
                    }
                }
            }
        }

        return $next($request);
    }

    private function isValidFile($file): bool
    {
        if (!$file->isValid()) {
            return false;
        }

        // Verificar tamanho máximo (2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return false;
        }

        // Verificar extensão
        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'gif', 'webp',
            'pdf', 'doc', 'docx', 'xls', 'xlsx'
        ];

        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Verificar MIME type
        $allowedMimes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf', 'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        $mimeType = $file->getMimeType();
        
        if (!in_array($mimeType, $allowedMimes)) {
            return false;
        }

        return true;
    }
} 