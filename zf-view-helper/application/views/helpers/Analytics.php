<?php
/** application/views/helpers/Analytics.php **/

/**
 * Google analytics view helper
 *
 * @author Felipe Rodrigues <felipe@felipedjinn.com.br> 
 * @link   https://github.com/felipedjinn/blog-posts/tree/master/zf-view-helper
 */
//class Zend_View_Helper_Analytics extends Zend_View_Helper_Abstract
class ZF_View_Helper_Analytics extends Zend_View_Helper_Abstract
{
    /**
     * Account ID
     *
     * @var string
     */
    protected $_account;

    /**
     * Domain name
     *
     * @var string
     */
    protected $_domain;

    /**
     * Render google analytics code
     *
     * @param  string $account
     * @param  string $domain
     * @return string
     */
    public function analytics($account, $domain = null)
    {
        $this->_account = trim($account);

        if ( null != $domain ) {
            $this->_domain = trim($domain);
        }

        return $this->_render();
    }

    /**
     * Render google analytics code
     *
     * @return string
     */
    protected function _render()
    {
        $html  = "<script type=\"text/javascript\">\n";
        $html .= "    var _gaq = _gaq || [];\n";
        $html .= "    _gaq.push(['_setAccount', '{$this->_account}']);\n";

        if ( null != $this->_domain ) {
            $html .= "    _gaq.push(['_setDomainName', '{$this->_domain}']);\n";
        }

        $html .= "    _gaq.push(['_trackPageview']);\n\n";
        $html .= "    (function() {\n";
        $html .= "        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n";
        $html .= "        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n";
        $html .= "        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n";
        $html .= "    })();\n";


        return $html . "</script>\n";
    }
}
