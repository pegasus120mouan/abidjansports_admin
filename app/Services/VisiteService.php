<?php

namespace App\Services;

use App\Models\Visite;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class VisiteService
{
    public function enregistrerVisite($request, $articleId = null, $typePage = 'autre')
    {
        $ip = $request->ip();
        $ipHash = hash('sha256', $ip . config('app.key'));
        
        // Éviter les doublons dans les 5 dernières minutes pour la même page
        $cacheKey = "visite_{$ipHash}_{$typePage}_{$articleId}";
        if (Cache::has($cacheKey)) {
            return null;
        }
        
        // Récupérer les infos de géolocalisation (avec cache de 24h par IP)
        $geoData = $this->getGeoData($ip);
        
        // Parser le User-Agent
        $userAgent = $request->userAgent();
        $navigateur = $this->parseNavigateur($userAgent);
        $plateforme = $this->parsePlateforme($userAgent);
        
        $visite = Visite::create([
            'ip_hash' => $ipHash,
            'pays' => $geoData['pays'] ?? null,
            'code_pays' => $geoData['code_pays'] ?? null,
            'ville' => $geoData['ville'] ?? null,
            'navigateur' => $navigateur,
            'plateforme' => $plateforme,
            'page_visitee' => $request->path(),
            'article_id' => $articleId,
            'type_page' => $typePage,
        ]);
        
        // Incrémenter le compteur de vues de l'article
        if ($articleId) {
            Article::where('id', $articleId)->increment('vues');
        }
        
        // Cache pour éviter les doublons (5 minutes)
        Cache::put($cacheKey, true, 300);
        
        return $visite;
    }
    
    protected function getGeoData($ip)
    {
        // Ne pas géolocaliser les IPs locales
        if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return ['pays' => 'Local', 'code_pays' => 'LC', 'ville' => 'Localhost'];
        }
        
        $cacheKey = "geo_ip_{$ip}";
        
        return Cache::remember($cacheKey, 86400, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city");
                
                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'pays' => $response->json('country'),
                        'code_pays' => $response->json('countryCode'),
                        'ville' => $response->json('city'),
                    ];
                }
            } catch (\Exception $e) {
                // Silencieux en cas d'erreur
            }
            
            return ['pays' => null, 'code_pays' => null, 'ville' => null];
        });
    }
    
    protected function parseNavigateur($userAgent)
    {
        if (empty($userAgent)) return 'Inconnu';
        
        $navigateurs = [
            'Chrome' => '/Chrome\/[\d.]+/',
            'Firefox' => '/Firefox\/[\d.]+/',
            'Safari' => '/Safari\/[\d.]+/',
            'Edge' => '/Edg\/[\d.]+/',
            'Opera' => '/OPR\/[\d.]+/',
            'IE' => '/MSIE|Trident/',
        ];
        
        foreach ($navigateurs as $nom => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $nom;
            }
        }
        
        return 'Autre';
    }
    
    protected function parsePlateforme($userAgent)
    {
        if (empty($userAgent)) return 'Inconnu';
        
        $plateformes = [
            'Windows' => '/Windows/',
            'Mac' => '/Macintosh/',
            'Linux' => '/Linux/',
            'Android' => '/Android/',
            'iOS' => '/iPhone|iPad/',
        ];
        
        foreach ($plateformes as $nom => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $nom;
            }
        }
        
        return 'Autre';
    }
}
