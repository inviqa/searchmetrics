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
        $expectation = $this->getMarkupFixture()->html();
        $this->getMarkup()->shouldReturn($expectation);
    }

    function it_should_be_able_to_get_the_number_of_heading_tags()
    {
        $this->getElementCount('h1')->shouldReturn(1);
        $this->getElementCount('h2')->shouldReturn(2);
    }

    function it_should_be_able_to_get_the_number_of_image_tags()
    {
        $this->getElementCount('img')->shouldReturn(1);
    }

    function it_should_be_able_to_get_a_count_of_any_tag()
    {
        $this->getElementCount('blockquote')->shouldReturn(1);
        $this->getElementCount('p')->shouldReturn(1);
        $this->getElementCount('li')->shouldReturn(3);
    }

    function it_should_get_h1_content()
    {
        $this->getHeadingContent('h1')
            ->shouldReturn(['With great power comes great responsibility']);
    }

    function it_should_get_h2_content()
    {
        $this->getHeadingContent('h2')->shouldReturn([
            'Go web! Fly! Up, up, and away web! Shazaam! Go! Go! Go web go! Tally ho.',
            'Spider Man will always have enemies. I can\'t let you take that risk.',
        ]);
    }

    function it_gets_the_word_count()
    {
        $this->getTermCount()->shouldReturn(79);
    }

    function it_should_get_an_array_containing_element_counts_like_the_api_response()
    {
        $expectation = [
            'url' => 'text',
            'elements' => [
                'h1' => 1,
                'h2' => 2,
                'img' => 1,
                'video' => 0,
                'author' => 0,
            ],
            'termCount' => 79,
        ];

        $this->getKpiApiResponse()->shouldReturn($expectation);
    }

    private function getMarkupFixture()
    {
        $markup = file_get_contents(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'htmlFixture.html');

        return new Crawler($markup);
    }

}
