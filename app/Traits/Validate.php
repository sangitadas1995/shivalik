<?php

namespace App\Traits;

use App\Models\Customer;

trait Validate
{
    public function company_name($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[a-zA-Z ]+$/', $str);
            if ($valid) {
                return ['status' => true];
            } else {
                return ['status' => false, 'message' => 'Company name should be characters only.'];
            }
        } else {
            return ['status' => false, 'message' => 'Company name field is required.'];
        }
    }

    public function gst_number($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', $str);
            if ($valid) {
                $find_gst = Customer::where([
                    'gst_no' => $str
                ])
                    ->first();
                if (!empty($find_gst)) {
                    return ['status' => false, 'message' => 'GST number already exist.'];
                } else {
                    return ['status' => true];
                }
            } else {
                return ['status' => false, 'message' => 'GST number is invalid format.'];
            }
        } else {
            return ['status' => false, 'message' => 'GST number field is required.'];
        }
    }

    public function contact_person($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[a-zA-Z ]+$/', $str);
            if ($valid) {
                return ['status' => true];
            } else {
                return ['status' => false, 'message' => 'Contact person should be characters only.'];
            }
        } else {
            return ['status' => false, 'message' => 'Contact person field is required.'];
        }
    }

    public function contact_person_designation($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[a-zA-Z ]+$/', $str);
            if ($valid) {
                return ['status' => true];
            } else {
                return ['status' => false, 'message' => 'Contact person designation should be characters only.'];
            }
        } else {
            return ['status' => true];
        }
    }

    public function mobile_number($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[6-9]\d{9}$/', $str);
            if ($valid) {
                if (strlen($str) === 10) {
                    $find_mob = Customer::where(function ($q) use ($str) {
                        $q->where('mobile_no', $str)
                            ->orWhere('alter_mobile_no', $str)
                            ->orWhere('phone_no', $str)
                            ->orWhere('alternative_phone_no', $str);
                    })
                        ->first();

                    if (!empty($find_mob)) {
                        return ['status' => false, 'message' => 'Mobile number is already exist.'];
                    } else {
                        return ['status' => true];
                    }
                } else {
                    return ['status' => false, 'message' => 'Mobile number should be 10 digits.'];
                }
            } else {
                return ['status' => false, 'message' => 'Mobile number is invalid format.'];
            }
        } else {
            return ['status' => false, 'message' => 'Mobile number field is required.'];
        }
    }

    public function alternate_mobile_number($str, $mob_n)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[6-9]\d{9}$/', $str);
            if ($str === $mob_n) {
                return ['status' => false, 'message' => 'Alternate mobile number should not be the same as mobile number.'];
            } else {
                if ($valid) {
                    if (strlen($str) === 10) {
                        $find_mob = Customer::where(function ($q) use ($str) {
                            $q->where('mobile_no', $str)
                                ->orWhere('alter_mobile_no', $str)
                                ->orWhere('phone_no', $str)
                                ->orWhere('alternative_phone_no', $str);
                        })
                            ->first();

                        if (!empty($find_mob)) {
                            return ['status' => false, 'message' => 'Alternate mobile number is already exist.'];
                        } else {
                            return ['status' => true];
                        }
                    } else {
                        return ['status' => false, 'message' => 'Alternate mobile number should be 10 digits.'];
                    }
                } else {
                    return ['status' => false, 'message' => 'Alternate mobile number is invalid format.'];
                }
            }
        } else {
            return ['status' => true];
        }
    }

    public function valid_email($str)
    {
        if (!empty($str)) {
            if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
                $find_email = Customer::where([
                    'email' => $str
                ])
                    ->orWhere('alternative_email_id', $str)
                    ->first();
                if (!empty($find_email)) {
                    return ['status' => false, 'message' => 'Email is already exist.'];
                } else {
                    return ['status' => true];
                }
            } else {
                return ['status' => false, 'message' => 'Email is invalid format.'];
            }
        } else {
            return ['status' => false, 'message' => 'Email field is required.'];
        }
    }

    public function alternate_email($str, $email)
    {
        if (!empty($str)) {
            if ($email === $str) {
                return ['status' => false, 'message' => 'Alternate email should not be the same as email.'];
            } else {
                if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
                    $find_email = Customer::where([
                        'email' => $str
                    ])
                        ->orWhere('alternative_email_id', $str)
                        ->first();
                    if (!empty($find_email)) {
                        return ['status' => false, 'message' => 'Alternate email is already exist.'];
                    } else {
                        return ['status' => true];
                    }
                } else {
                    return ['status' => false, 'message' => 'Alternate email is invalid format.'];
                }
            }
        } else {
            return ['status' => false, 'message' => 'Alternate email field is required.'];
        }
    }

    public function phone_no($str, $mob_n, $amob_n)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[0-9]\d{10}$/', $str);
            if ($str === $mob_n) {
                return ['status' => false, 'message' => 'Phone number should not be the same as mobile number.'];
            } else {
                if ($str === $amob_n) {
                    return ['status' => false, 'message' => 'Phone number should not be the same as alternate mobile number.'];
                } else {
                    if ($valid) {
                        $find_mob = Customer::where(function ($q) use ($str) {
                            $q->where('mobile_no', $str)
                                ->orWhere('alter_mobile_no', $str)
                                ->orWhere('phone_no', $str)
                                ->orWhere('alternative_phone_no', $str);
                        })
                            ->first();

                        if (!empty($find_mob)) {
                            return ['status' => false, 'message' => 'Phone number is already exist.'];
                        } else {
                            return ['status' => true];
                        }
                    } else {
                        return ['status' => false, 'message' => 'Phone number is invalid format.'];
                    }
                }
            }
        } else {
            return ['status' => true];
        }
    }

    public function alternate_phone_no($str, $mob_n, $amob_n, $p_n)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[0-9]\d{10}$/', $str);
            if ($str === $mob_n) {
                return ['status' => false, 'message' => 'Alternate phone number should not be the same as mobile number.'];
            } else {
                if ($str === $amob_n) {
                    return ['status' => false, 'message' => 'Alternate phone number should not be the same as alternate mobile number.'];
                } else {
                    if ($str === $p_n) {
                        return ['status' => false, 'message' => 'Alternate phone number should not be the same as phone number.'];
                    } else {
                        if ($valid) {
                            $find_mob = Customer::where(function ($q) use ($str) {
                                $q->where('mobile_no', $str)
                                    ->orWhere('alter_mobile_no', $str)
                                    ->orWhere('phone_no', $str)
                                    ->orWhere('alternative_phone_no', $str);
                            })
                                ->first();

                            if (!empty($find_mob)) {
                                return ['status' => false, 'message' => 'Alternate phone number is already exist.'];
                            } else {
                                return ['status' => true];
                            }
                        } else {
                            return ['status' => false, 'message' => 'Alternate phone number is invalid format.'];
                        }
                    }
                }
            }
        } else {
            return ['status' => true];
        }
    }

    public function customer_website($str)
    {
        if (!empty($str)) {
            if (filter_var($str, FILTER_VALIDATE_URL)) {
                $find_url = Customer::where([
                    'customer_website' => $str
                ])
                    ->first();
                if (!empty($find_url)) {
                    return ['status' => false, 'message' => 'Customer website is already exist.'];
                } else {
                    return ['status' => true];
                }
            } else {
                return ['status' => false, 'message' => 'Customer website is invalid format.'];
            }
        } else {
            return ['status' => true];
        }
    }

    public function address($str)
    {
        if (!empty($str)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'Address field is required.'];
        }
    }

    public function country($str)
    {
        if (!empty($str)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'Country field is required.'];
        }
    }

    public function state($str)
    {
        if (!empty($str)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'State field is required.'];
        }
    }

    public function city($str)
    {
        if (!empty($str)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'City field is required.'];
        }
    }

    public function pincode($str)
    {
        if (!empty($str)) {
            $valid = preg_match('/^[1-9][0-9]{5}$/', $str);
            if ($valid) {
                return ['status' => true];
            } else {
                return ['status' => false, 'message' => 'Pincode is invalid format.'];
            }
        } else {
            return ['status' => false, 'message' => 'Pincode field is required.'];
        }
    }

    public function print_margin($str)
    {
        if (!empty($str)) {
            if (is_numeric($str)) {
                return ['status' => true];
            } else {
                return ['status' => false, 'message' => 'Print margin should be digits only.'];
            }
        } else {
            return ['status' => false, 'message' => 'Print margin field is required.'];
        }
    }
}
