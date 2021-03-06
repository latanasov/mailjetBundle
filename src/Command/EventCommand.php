<?php
namespace Welp\MailjetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EventCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('welp:mailjet:event-endpoint')
            ->setDescription('Prints URL endpoint that should be configured at mailjet.com website')
            ->addArgument('baseurl', InputArgument::REQUIRED, 'Baseurl with domain to be used in URL, i.e. https://example.com')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // @TODO automatically add callbackurl with MailJet API V3
        $domain = $input->getArgument('baseurl');
        $uri = $this->getRouter()->generate($this->getRouteName(), array(
            'token' => $this->getToken()
        ));
        $output->writeln(sprintf('%s/%s', rtrim($domain, '/'), ltrim($uri, '/')));
    }

    /**
     * @return \Symfony\Component\Routing\RouterInterface
     */
    protected function getRouter()
    {
        return $this->getContainer()->get('router');
    }

    /**
     * @return string
     */
    protected function getRouteName()
    {
        return $this->getContainer()->getParameter('welp_mailjet.event_endpoint_route');
    }

    /**
     * @return string
     */
    protected function getToken()
    {
        return $this->getContainer()->getParameter('welp_mailjet.event_endpoint_token');
    }
}
