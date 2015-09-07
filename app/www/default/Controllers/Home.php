<?php

class Home extends Ctrlr
{
    function __construct()
    {
        parent::__construct();
        $this->post = new Post();
    }

    public function contact()
    {
        $input = new Input();
        if ($input->isSubmitted('submit')) {
            $user = new User();

            if (!$errors = $user->checkMail($input->get('email'))) {
                $subject    = 'Contact Msg from ' . $input->get('name');
                $body       = 'user : ' . $input->get('name');
                $body      .= '\n email : ' . $input->get('email');
                $body      .= '\n has sent the following message : \n' . $input->get('Fmessage');

                if (Send::mail('Thijs.dp@gmail.com', $subject, $body)) $response['notice'] = Lang::get('notice.user.success');

            }
            else $response['errors'] = $errors;
            return $response;  
        }
    }
}
