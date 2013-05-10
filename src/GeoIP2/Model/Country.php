<?php

namespace GeoIP2\Model;

/**
 * This class provides a model for the data returned by the GeoIP2 Country
 * end point.
 *
 * The only difference between the City, City/ISP/Org, and Omni model
 * classes is which fields in each record may be populated. See
 * http://dev.maxmind.com/geoip/geoip2/web-services more details.
 *
 * @property \GeoIP2\Record\Continent $continent Continent data for the
 * requested IP address.
 *
 * @property \GeoIP2\Record\Country $country Country data for the requested
 * IP address. This object represents the country where MaxMind believes the
 * end user is located.
 *
 * @property \GeoIP2\Record\Country $registeredCountry Registered country
 * data for the requested IP address. This record represents the country
 * where the ISP has registered a given IP block in and may differ from the
 * user's country.
 *
 * @property \GeoIP2\Record\RepresentedCountry $representedCountry
 * Represented country data for the requested IP address. The represented
 * country is used for things like military bases or embassies. It is only
 * present when the represented country differs from the country.
 *
 * @property \GeoIP2\Record\Traits $traits Data for the traits of the
 * requested IP address.
 */
class Country
{
    private $continent;
    private $country;
    private $languages;
    private $registeredCountry;
    private $representedCountry;
    private $traits;
    private $raw;

    /**
     * @ignore
     */
    public function __construct($raw, $languages)
    {
        $this->raw = $raw;

        $this->continent = new \GeoIP2\Record\Continent(
            $this->get('continent'),
            $languages
        );
        $this->country = new \GeoIP2\Record\Country(
            $this->get('country'),
            $languages
        );
        $this->registeredCountry = new \GeoIP2\Record\Country(
            $this->get('registered_country'),
            $languages
        );
        $this->representedCountry = new \GeoIP2\Record\RepresentedCountry(
            $this->get('represented_country'),
            $languages
        );
        $this->traits = new \GeoIP2\Record\Traits($this->get('traits'));

        $this->languages = $languages;
    }

    /**
     * @ignore
     */
    protected function get($field)
    {
        return isset($this->raw[$field]) ? $this->raw[$field] : array();
    }

    /**
     * @ignore
     */
    public function __get ($attr)
    {
        if ($attr != "instance" && isset($this->$attr)) {
            return $this->$attr;
        }

        throw new \RuntimeException("Unknown attribute: $attr");
    }
}
