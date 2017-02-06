<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '{field} ის ველის შევსება აუცილებელია.';
$lang['form_validation_isset']			= 'არ არის მითითებული {field} ველი';
$lang['form_validation_valid_email']		= 'მიუთითეთ ვალიდური ელ-ფოსტა';
$lang['form_validation_valid_emails']		= '{field} უნდა შეიცავდეს მხოლოდ ვალიდურ ელ-ფოსტის მისამართს';
$lang['form_validation_valid_url']		= '{field} ში მიუთითეთ რეალური URL მისამართი.';
$lang['form_validation_valid_ip']		= '{field} უნდა შეიცავდეს ვალიდურ IP მისამართს';
$lang['form_validation_min_length']		= '{field} ველში მინიმუმ უნდა მიუთითოთ {param} სიმბოლო';
$lang['form_validation_max_length']		= '{field} ველში მაქსიმუმ უნდა მიუთითოთ {param} სიმბოლო';
$lang['form_validation_exact_length']		= '{field} ველში უნდა მიუთითოდ {param} სიმბოლო';
$lang['form_validation_alpha']			= '{field} ველი უნდა შეიცავდეს მხოლოდ ასოებს';
$lang['form_validation_alpha_numeric']		= '{field} ველი უნდა შეიცავდეს მხოლოდ ასოებს და ციფრებს.';
$lang['form_validation_alpha_numeric_spaces']	= '{field} უნდა შეიცავდეს მხოლოდ ციფრებს და სიმბოლოებს';
$lang['form_validation_alpha_dash']		= '{field} უნდა შეიცავდეს მხოლოდ ციფრებს და სიმბოლოებს';
$lang['form_validation_numeric']		= '{field} ველი უნდა შეიცავდეს მხოლოდ ციფრებს';
$lang['form_validation_is_numeric']		= 'The {field} ველი უნდა შეიცავდეს მხოლოდ ციფრებს';
$lang['form_validation_integer']		= '{field} უნდა შეიცავდეს მხოლოდ რიცხვებს';
$lang['form_validation_regex_match']		= '{field} არასწორ ფორმატშია შევსებული';
$lang['form_validation_matches']		= 'პაროლი არ ემთხვევა ერთმანეთს';
$lang['form_validation_differs']		= '{field} უნდა განსხვავდებოდეს {param} -ისაგან.';
$lang['form_validation_is_unique'] 		= '{field} ველი უნდა იყოს უნიკალური';
$lang['form_validation_is_natural']		= '{field} უნდა შეიცავდეს მხოლოდ ციფრებს';
$lang['form_validation_is_natural_no_zero']	= '{field} უნდა შეიცავდეს ციფრებს და უნდა იყოს 0-ზე მეტი';
$lang['form_validation_decimal']		= '{field} უნდა შეიცავდეს ათწილადს';
$lang['form_validation_less_than']		= '{field} უნდა იყოს {param}-ზე ნაკლები';
$lang['form_validation_less_than_equal_to']	= '{field} უნდა შეიცავდეს ციფრს, რომელიც ნაკლებია ან მეტია {param}.';
$lang['form_validation_greater_than']		= '{field} უნდა შეიცავდეს ციფრს, რომელიც მეტია {param}.';
$lang['form_validation_greater_than_equal_to']	= 'The {field} უნდა შეიცავდეს ციფრს, რომელიც მეტია ან ტოლია {param}.';
$lang['form_validation_error_message_not_set']	= 'Unable to access an error message corresponding to your field name {field}.';
$lang['form_validation_in_list']		= '{field} field must be one of: {param}.';
