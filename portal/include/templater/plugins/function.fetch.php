<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>            |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: http://www.x-cart.com/license.php                     |
|                                                                             |
| THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
| (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
| FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
| THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
| LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
| INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
| (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
| NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
| PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
| SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
| GRANTED BY THIS AGREEMENT.                                                  |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Templater plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     fetch
 * -------------------------------------------------------------
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v17 (xcart_4_5_5), 2013-02-04 14:14:03, function.fetch.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../../"); die("Access denied"); }

function smarty_function_fetch($params, &$smarty)
{
    if (!isset($params['file']) || empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }

    $content = '';
    if ($smarty->security && !preg_match('!^(http|ftp)://!Si', $params['file'])) {
        $_params = array(
            'resource_type' => 'file',
            'resource_name' => $params['file']
        );
        require_once(SMARTY_CORE_DIR . 'core.is_secure.php');
        if (!smarty_core_is_secure($_params, $smarty)) {
            $smarty->_trigger_fatal_error('[plugin] (secure mode) fetch \'' . $params['file'] . '\' is not allowed');
            return;
        }

        // fetch the file
        $fp = @fopen($params['file'], 'r');
        if ($fp) {
            while(!feof($fp)) {
                $content .= fgets ($fp,4096);
            }
            fclose($fp);

        } else {
            $smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] . '\'');
            return;
        }

    } else {
        // not a local file
        if (preg_match('!^http://!i',$params['file'])) {
            // http fetch
            if ($uri_parts = parse_url($params['file'])) {
                // set defaults
                $host = $server_name = $uri_parts['host'];
                $timeout = 30;
                $accept = "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*";
                $agent = "Smarty Template Engine ".$smarty->_version;
                $referer = '';
                $uri = !empty($uri_parts['path']) ? $uri_parts['path'] : '/';
                $uri .= !empty($uri_parts['query']) ? '?' . $uri_parts['query'] : '';
                $_is_proxy = false;
                $port = empty($uri_parts['port']) ? 80 : $uri_parts['port'];
                if (!empty($uri_parts['user'])) {
                    $user = $uri_parts['user'];
                    if (!empty($uri_parts['pass'])) {
                        $pass = $uri_parts['pass'];
                    }
                }
                // loop through parameters, setup headers
                foreach ($params as $param_key => $param_value) {
                    switch ($param_key) {
                        case 'file':
                        case 'assign':
                        case 'assign_headers':
                            break;

                        case 'user':
                            if (!empty($param_value)) {
                                $user = $param_value;
                            }
                            break;

                        case 'pass':
                            if (!empty($param_value)) {
                                $pass = $param_value;
                            }
                            break;

                        case 'accept':
                            if (!empty($param_value)) {
                                $accept = $param_value;
                            }
                            break;

                        case 'header':
                            if (!empty($param_value)) {
                                if (!preg_match('![\w\d-]+: .+!',$param_value)) {
                                    $smarty->_trigger_fatal_error("[plugin] invalid header format '".$param_value."'");
                                    return;
                                } else {
                                    $extra_headers[] = $param_value;
                                }
                            }
                            break;

                        case 'proxy_host':
                            if (!empty($param_value)) {
                                $proxy_host = $param_value;
                            }
                            break;

                        case 'proxy_port':
                            if (!preg_match('!\D!', $param_value)) {
                                $proxy_port = (int) $param_value;

                            } else {
                                $smarty->_trigger_fatal_error("[plugin] invalid value for attribute '".$param_key."'");
                                return;
                            }
                            break;

                        case 'agent':
                            if (!empty($param_value)) {
                                $agent = $param_value;
                            }
                            break;

                        case 'referer':
                            if (!empty($param_value)) {
                                $referer = $param_value;
                            }
                            break;

                        case 'timeout':
                            if (!preg_match('!\D!', $param_value)) {
                                $timeout = (int) $param_value;

                            } else {
                                $smarty->_trigger_fatal_error("[plugin] invalid value for attribute '".$param_key."'");
                                return;
                            }
                            break;

                        default:
                            $smarty->_trigger_fatal_error("[plugin] unrecognized attribute '".$param_key."'");
                            return;
                    }
                }

                if (!empty($proxy_host) && !empty($proxy_port)) {
                    $_is_proxy = true;
                    $fp = fsockopen($proxy_host,$proxy_port,$errno,$errstr,$timeout);

                } else {
                    $fp = fsockopen($server_name,$port,$errno,$errstr,$timeout);
                }

                if (!$fp) {
                    $smarty->_trigger_fatal_error("[plugin] unable to fetch: $errstr ($errno)");
                    return;
                }

                if ($_is_proxy) {
                    fputs($fp, 'GET ' . $params['file'] . " HTTP/1.0\r\n");
                } else {
                    fputs($fp, "GET $uri HTTP/1.0\r\n");
                }

                if (!empty($host)) {
                    fputs($fp, "Host: $host\r\n");
                }

                if (!empty($accept)) {
                    fputs($fp, "Accept: $accept\r\n");
                }

                if (!empty($agent)) {
                    fputs($fp, "User-Agent: $agent\r\n");
                }

                if (!empty($referer)) {
                    fputs($fp, "Referer: $referer\r\n");
                }

                if (isset($extra_headers) && is_array($extra_headers)) {
                    foreach ($extra_headers as $curr_header) {
                        fputs($fp, $curr_header."\r\n");
                    }
                }

                if (!empty($user) && !empty($pass)) {
                    fputs($fp, "Authorization: BASIC ".base64_encode("$user:$pass")."\r\n");
                }

                fputs($fp, "\r\n");

                while(!feof($fp)) {
                    $content .= fgets($fp,4096);
                }
                fclose($fp);

                $csplit = explode("\r\n\r\n", $content, 2);

                $content = $csplit[1];

                if (!empty($params['assign_headers'])) {
                    $smarty->assign($params['assign_headers'], explode("\r\n", $csplit[0]));
                }

            } else {
                $smarty->_trigger_fatal_error("[plugin] unable to parse URL, check syntax");
                return;
            }

        } else {
            // ftp fetch
            $fp = @fopen($params['file'],'r');
            if ($fp) {
                while(!feof($fp)) {
                    $content .= fgets ($fp, 4096);
                }
                fclose($fp);

            } else {
                $smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] .'\'');
                return;
            }
        }

    }

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'],$content);
    } else {
        return $content;
    }
}

?>
