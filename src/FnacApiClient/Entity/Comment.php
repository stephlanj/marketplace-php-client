<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Entity;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * Represent a customer comment reply use when dealing with ClientOrderCommentUpdate
 *
 * @author     Fnac
 * @version    1.0.0
 */

class Comment extends Entity
{
    /** Send Var **/
    private $reply;

    /** Get Var **/
    private $status;
    private $errors;

    /** Both **/
    private $id;

    /**
     * {@inheritDoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format, $properties = null)
    {
        return array(
            '@id' => $this->id, 'comment_reply' => $this->reply
        );
    }

    /**
     * {@inheritDoc}
     */
    public function denormalize(NormalizerInterface $normalizer, $data, $format = null)
    {
        $this->id = $data['@id'];
        $this->status = $data['@status'];

        $this->errors = new \ArrayObject();

        if (isset($data['error'])) {
            if (isset($data['error'][0])) {
                foreach ($data['error'] as $error) {
                    $tmpObj = new Error();
                    $tmpObj->denormalize($normalizer, $error, $format);
                    $this->errors[] = $tmpObj;
                }
            } else {
                $tmpObj = new Error();
                $tmpObj->denormalize($normalizer, $data['error'], $format);
                $this->errors[] = $tmpObj;
            }
        }
    }

    /**
     * Set a reply for a comment
     *
     * @param string $reply : Reply for the comment
     */
    public function setReply($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Set comment's unique identifier from fnac
     *
     * @param string $id : Id for the comment
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Comment's unique identifier from fnac
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the status of this comment
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return a list of error
     *
     * @return ArrayObject<Error>
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
