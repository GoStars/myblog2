<?php
    namespace Myblog2\Controllers;

    use Http\Request;
    use Http\Response;
    use Myblog2\Template\Renderer;

    class Homepage {
        private $request;

        private $response;

        private $renderer;

        public function __construct(
            Request $request,
            Response $response,
            Renderer $renderer
        ) {
            $this->request = $request;
            $this->response = $response;
            $this->renderer = $renderer;
        }

        public function show() {
            $data = [
                'name' => $this->request->getParameter('name', 'stranger')
            ];
            $html = $this->renderer->render('homepage', $data);
            $this->response->setContent($html);
        }
    }
