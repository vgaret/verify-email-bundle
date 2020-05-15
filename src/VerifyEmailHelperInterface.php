<?php

/*
 * This file is part of the SymfonyCasts VerifyEmailBundle package.
 * Copyright (c) SymfonyCasts <https://symfonycasts.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymfonyCasts\Bundle\VerifyEmail;

use SymfonyCasts\Bundle\VerifyEmail\Exception\ExpiredSignatureException;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;

/**
 * Generates & validates a signed URL for email verification/confirmation.
 *
 * @author Jesse Rushlow <jr@rushlow.dev>
 * @author Ryan Weaver   <ryan@symfonycasts.com>
 */
interface VerifyEmailHelperInterface
{
    /**
     * Get a signed Url that can be emailed to a user.
     *
     * @param string $routeName   name of route that will be used to verify users
     * @param string $userId      unique user identifier
     * @param string $userEmail   the email that is being verified
     * @param array  $queryParams any additional query string parameters that will be a part of the signed URL
     */
    public function generateSignature(string $routeName, string $userId, string $userEmail, array $queryParams = []): VerifyEmailSignatureComponents;

    /**
     * Validate a signed Url provided by the user.
     *
     * The $userEmail should be the email address that the currently-authenticated
     * user is trying to get validated. This is usually the current user's
     * email address.
     *
     * In more a complex setup, where you allow a user to verify multiple
     * emails, this would be the email that the currently-authenticated user
     * is trying to validate. You may even store a user's many email addresses
     * (and whether or not each is verified) in another database table. In
     * that case, you would need to call this method with each unverified
     * email in that table (for the currently-authenticated user) to see if
     * the signature is valid for any of the email addresses. If you find the
     * one that is valid, you could then mark that email as "confirmed".
     *
     * @param string $signedUrl the URI that was submitted by the user
     * @param string $userId    currently-authenticated user's unique identifier
     * @param string $userEmail currently-authenticated user's email, or, more specifically,
     *                          the email that the current user is attempting to validate
     *
     * @throws ExpiredSignatureException
     */
    public function isValidSignature(string $signedUrl, string $userId, string $userEmail): bool;

    /**
     * Get the length of time in seconds that a signed uri is valid.
     */
    public function getSignatureLifetime(): int;
}
