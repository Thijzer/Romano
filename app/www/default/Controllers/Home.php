<?php

class Home extends Ctrlr
{
    function __construct()
    {
        parent::__construct();
        $this->post = new Post();
        $this->options['offset'] = 0;
        $this->options['limit'] = 4;
    }

    public function index()
    {
        $response['post'] = $this->post->getPosts($this->options['limit'], $this->options['offset']);
        $response['titles'] = $this->post->getTitles();
        return $response;
    }

    public function pagination()
    {
        $requestedPage = 1;
        if (!isset($this->params['page'])) {
            $this->params['page'] = 1;
        }
        $this->options['num_items'] = $this->post->getRowCount();
        $requestedPage = (int) $this->params['page'];
        $this->options['num_pages'] = (int) ceil($this->options['num_items'] / $this->options['limit']);

        if ($this->options['num_pages'] == 0) {
            $this->options['num_pages'] = 1;
        }
        if ($requestedPage > $this->options['num_pages'] || $requestedPage < 1) {
            Output::redirect(404);
        }

        $this->options['requested_page'] = $requestedPage;
        $this->options['prev'] = $requestedPage-1;
        $this->options['next'] = $requestedPage+1;
        $this->options['url'] = '/page';
        $this->options['next_lbl'] = Lang::get('lbl.next');
        $this->options['prev_lbl'] = Lang::get('lbl.prev');
        $this->options['offset'] = ($this->options['requested_page'] * $this->options['limit']) - $this->options['limit'];
        return array( 'pages' => $this->options);

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
