<?php namespace spec\Searchmetrics\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DomCrawler\Crawler;

class MarkupParserSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith($this->getMarkupFixture());
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Searchmetrics\Parsers\MarkupParser');
    }

    function it_should_be_able_to_convert_a_string_to_a_crawler()
    {
        $this->getCrawler()->shouldReturnAnInstanceOf(Crawler::class);
    }

    function it_should_be_able_to_access_raw_markup()
    {
        // The crawler can change formatting, which would cause this spec to fail. So here we're creating a new Crawler
        // instance and calling ->html() manually to we can test against a Crawler parsed version of our fixture.
        $expectation = (new Crawler($this->getMarkupFixture()))->html();
        $this->getMarkup()->shouldReturn($expectation);
    }

    private function getMarkupFixture()
    {
        return file_get_contents(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'htmlFixture.html');
    }
}
