<?php
/**
 * Created by PhpStorm.
 * User: nbonniot
 * Date: 16/09/16
 * Time: 15:36
 */

namespace Lch\ComponentsBundle\Listener;


use Lch\ComponentsBundle\Event\RenderListRowActionsEvent;
use Lch\ComponentsBundle\Model\AdminIcons;
use Lch\ComponentsBundle\Model\Action;

abstract class ListListener
{
    /**
     * Add common actions to all lists
     * TODO : externalisze this in config.yml as parameters
     * @param RenderListRowActionsEvent $actionsEvent
     * @return array[Action] $actions
     */
    protected function addCommonActions(RenderListRowActionsEvent $actionsEvent) {

        $options = $actionsEvent->getOptions();

        /************
         * Edit action
         */
        $editAction = new Action();
        $editAction
            ->setName('edit')
            ->setLabel($this->translator->trans('lch.components.list.item.edit'))
            ->setRoute("{$options['baseRoute']}edit")
                ->setRouteParameters(['id' => $actionsEvent->getRecord()->getId()])
            ->setAttributes(['class' => 'btn btn-primary'])
            ->setIcon(AdminIcons::EDIT)
        ;
        $actionsEvent->addAction($editAction);

        /************
         * Delete action
         */
        $deleteAction = new Action();
        $deleteAction
            ->setName('delete')
            ->setType(Action::FORM)
//                ->setMethod('DELETE')
                ->setLabel($this->translator->trans('lch.components.list.item.delete'))
                ->setRoute("{$options['baseRoute']}delete")
                ->setFormParameters([
                        'id' => $actionsEvent->getRecord()->getId(),
                        'class' => $options['entity']['class'],
                        'route' => "{$options['baseRoute']}list"
                    ])
                ->setAttributes(['class' => 'btn btn-danger'])
                ->setIcon(AdminIcons::REMOVE)
        ;
        $actionsEvent->addAction($deleteAction);
    }
}