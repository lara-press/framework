<?php

namespace LaraPress\Hashing;

use RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class WordPressHasher implements HasherContract {

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function make($value, array $options = [])
    {
        return wp_hash_password($value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array  $options
     *
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        $userId = isset($options['user_id']) ? $options['user_id'] : '';

        return wp_check_password($value, $hashedValue, $userId);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array  $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
