<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use FnacApiClient\Entity\IncidentOrderUpdate;

/**
 * IncidentUpdateResponse service base definition for incident update response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class IncidentUpdateResponse extends ResponseService
{
    private $orders;

    /**
     * {@inheritdoc}
     */
    public function denormalize(NormalizerInterface $normalizer, $data, $format = null)
    {
        parent::denormalize($normalizer, $data, $format);

        $this->orders = new \ArrayObject();

        if (isset($data['order'])) {
            if (isset($data['order'][0])) {
                foreach ($data['order'] as $message) {
                    $tmpObj = new IncidentOrderUpdate();
                    $tmpObj->denormalize($normalizer, $message, $format);
                    $this->orders[] = $tmpObj;
                }
            } elseif (!empty($data['order'])) {
                $tmpObj = new IncidentOrderUpdate();
                $tmpObj->denormalize($normalizer, $data['order'], $format);
                $this->orders[] = $tmpObj;
            }
        }
    }

    /**
     * Order updated list
     *
     * @see FnacApiClient\Entity\IncidentOrderUpdate
     *
     * @return ArrayObject<IncidentOrderUpdate>
     */
    public function getOrdersUpdates()
    {
        return $this->orders;
    }
}
