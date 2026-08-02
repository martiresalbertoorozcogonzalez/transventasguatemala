<?php

namespace App\Helpers;

class SocialHelper
{
    public static function getSocialLinks()
    {
        return config('social');
    }
    
    public static function shareUrl($platform, $url, $text)
    {
        $platforms = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=',
            'twitter' => 'https://twitter.com/intent/tweet?url=',
            'whatsapp' => 'https://wa.me/?text=',
            'telegram' => 'https://t.me/share/url?url=',
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=',
        ];
        
        if (!isset($platforms[$platform])) {
            return '#';
        }
        
        return $platforms[$platform] . urlencode($url) . ($text ? '&text=' . urlencode($text) : '');
    }
}