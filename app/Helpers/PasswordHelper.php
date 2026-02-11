<?php

namespace App\Helpers;

/**
 * PasswordHelper - PHP 8.4 Compatible Password Management
 * 
 * Provides modern password hashing and verification while maintaining
 * backward compatibility with existing MD5 passwords in the database.
 */
class PasswordHelper
{
    /**
     * Hash a password using password_hash
     */
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, [
            'cost' => 12,
        ]);
    }

    /**
     * Verify a password against a hash
     * Supports both modern BCRYPT and legacy MD5 hashes
     */
    public static function verify(string $password, string $hash): bool
    {
        // First try modern password_verify
        if (password_verify($password, $hash)) {
            return true;
        }

        // Fall back to MD5 for legacy passwords
        if (md5($password) === $hash) {
            return true;
        }

        return false;
    }

    /**
     * Check if a hash needs to be rehashed (e.g., legacy MD5)
     */
    public static function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, [
            'cost' => 12,
        ]);
    }

    /**
     * Legacy MD5 hash - only use for backward compatibility
     * @deprecated Use hash() instead
     */
    public static function legacyHash(string $password): string
    {
        return md5($password);
    }
}
