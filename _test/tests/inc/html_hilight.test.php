<?php

class html_hilight_test extends DokuWikiTest {

    function testHighlightOneWord() {
        $html = 'Foo bar Foo';
        $this->assertRegExp(
            '/Foo <span.*>bar<\/span> Foo/',
            html_hilight($html,'bar')
        );
    }

    function testHighlightTwoWords() {
        $html = 'Foo bar Foo php Foo';
        $this->assertRegExp(
            '/Foo <span.*>bar<\/span> Foo <span.*>php<\/span> Foo/',
            html_hilight($html,array('bar','php'))
        );
    }

    function testHighlightTwoWordsHtml() {
        $html = 'Foo <b>bar</b> <i>Foo</i> php Foo';
        $this->assertRegExp(
            '/Foo <b><span.*>bar<\/span><\/b> <i>Foo<\/i> <span.*>php<\/span> Foo/',
            html_hilight($html,array('bar','php'))
        );
    }

    function testNoMatchHtml() {
        $html = 'Foo <font>font</font> Bar';
        $this->assertRegExp(
            '/Foo <font><span.*>font<\/span><\/font> Bar/',
            html_hilight($html,'font')
        );
    }

    function testWildcardRight() {
        $html = 'foo bar foobar barfoo foobarfoo foo';
        $this->assertRegExp(
            '/foo <span.*>bar<\/span> foobar <span.*>bar<\/span>foo foobarfoo foo/',
            html_hilight($html,'bar*')
        );
    }

    function testWildcardLeft() {
        $html = 'foo bar foobar barfoo foobarfoo foo';
        $this->assertRegExp(
            '/foo <span.*>bar<\/span> foo<span.*>bar<\/span> barfoo foobarfoo foo/',
            html_hilight($html,'*bar')
        );
    }

    function testWildcardBoth() {
        $html = 'foo bar foobar barfoo foobarfoo foo';
        $this->assertRegExp(
            '/foo <span.*>bar<\/span> foo<span.*>bar<\/span> <span.*>bar<\/span>foo foo<span.*>bar<\/span>foo foo/',
            html_hilight($html,'*bar*')
        );
    }

    function testNoHighlight() {
        $html = 'Foo bar Foo';
        $this->assertRegExp(
            '/Foo bar Foo/',
            html_hilight($html,'php')
        );
    }

    function testMatchAttribute() {
        $html = 'Foo <b class="x">bar</b> Foo';
        $this->assertRegExp(
            '/Foo <b class="x">bar<\/b> Foo/',
            html_hilight($html,'class="x"')
        );
    }

    function testMatchAttributeWord() {
        $html = 'Foo <b class="x">bar</b> Foo';
        $this->assertEquals(
            'Foo <b class="x">bar</b> Foo',
            html_hilight($html,'class="x">bar')
        );
    }

    function testRegexInjection() {
        $html = 'Foo bar Foo';
        $this->assertRegExp(
            '/Foo bar Foo/',
            html_hilight($html,'*')
        );
    }

    function testRegexInjectionSlash() {
        $html = 'Foo bar Foo';
        $this->assertRegExp(
            '/Foo bar Foo/',
            html_hilight($html,'x/')
        );
    }

    function testMB() {
        $html = 'foo ???????????????? bar';
        $this->assertRegExp(
            '/foo <span.*>????????????????<\/span> bar/',
            html_hilight($html,'????????????????')
        );
    }

    function testMBright() {
        $html = 'foo ???????????????? bar';
        $this->assertRegExp(
            '/foo <span.*>????????<\/span>???????? bar/',
            html_hilight($html,'????????*')
        );
    }

    function testMBleft() {
        $html = 'foo ???????????????? bar';
        $this->assertRegExp(
            '/foo ????????<span.*>????????<\/span> bar/',
            html_hilight($html,'*????????')
        );
    }

    function testMBboth() {
        $html = 'foo ???????????????? bar';
        $this->assertRegExp(
            '/foo ????<span.*>????????<\/span>???? bar/',
            html_hilight($html,'*????????*')
        );
    }
}
