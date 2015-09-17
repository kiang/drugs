<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('License'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="licenses view">
                        <dl>
                            <dt><?php echo __('Id'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('License Id'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['license_id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Code'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['code']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Source'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['source']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Nhi Id'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['nhi_id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Shape'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['shape']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('S Type'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['s_type']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Color'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['color']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Odor'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['odor']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Abrasion'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['abrasion']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Size'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['size']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Note 1'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['note_1']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Note 2'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['note_2']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Image'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['image']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Cancel Status'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['cancel_status']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Cancel Date'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['cancel_date']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Cancel Reason'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['cancel_reason']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Expired Date'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['expired_date']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('License Date'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['license_date']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('License Type'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['license_type']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Old Id'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['old_id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Document Id'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['document_id']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Name'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['name']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Name English'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['name_english']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Disease'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['disease']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Formulation'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['formulation']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Package'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['package']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Type'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['type']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Class'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['class']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Ingredient'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['ingredient']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Vendor'); ?></dt>
                            <dd>
                                <?php echo $this->Html->link($license['Vendor']['name'], array('controller' => 'vendors', 'action' => 'view', $license['Vendor']['id'])); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Submitted'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['submitted']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Usage'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['usage']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Package Note'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['package_note']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Barcode'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['barcode']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Count Daily'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['count_daily']); ?>
                                &nbsp;
                            </dd>
                            <dt><?php echo __('Count All'); ?></dt>
                            <dd>
                                <?php echo h($license['License']['count_all']); ?>
                                &nbsp;
                            </dd>
                        </dl>
                    </div>
                    <div class="actions">
                        <h3><?php echo __('Actions'); ?></h3>
                        <ul>
                            <li><?php echo $this->Html->link(__('Edit License'), array('action' => 'edit', $license['License']['id'])); ?> </li>
                            <li><?php echo $this->Form->postLink(__('Delete License'), array('action' => 'delete', $license['License']['id']), array(), __('Are you sure you want to delete # %s?', $license['License']['id'])); ?> </li>
                            <li><?php echo $this->Html->link(__('List Licenses'), array('action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New License'), array('action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Vendors'), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Vendor'), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Drugs'), array('controller' => 'drugs', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Drug'), array('controller' => 'drugs', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Prices'), array('controller' => 'prices', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Price'), array('controller' => 'prices', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients Licenses'), array('controller' => 'ingredients_licenses', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredients License'), array('controller' => 'ingredients_licenses', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Attachments'), array('controller' => 'attachments', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
                            <li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
                            <li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Drugs'); ?></h3>
                        <?php if (!empty($license['Drug'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('License Id'); ?></th>
                                    <th><?php echo __('Vendor Id'); ?></th>
                                    <th><?php echo __('Manufacturer Description'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Drug'] as $drug): ?>
                                    <tr>
                                        <td><?php echo $drug['id']; ?></td>
                                        <td><?php echo $drug['license_id']; ?></td>
                                        <td><?php echo $drug['vendor_id']; ?></td>
                                        <td><?php echo $drug['manufacturer_description']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'drugs', 'action' => 'view', $drug['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'drugs', 'action' => 'edit', $drug['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'drugs', 'action' => 'delete', $drug['id']), array(), __('Are you sure you want to delete # %s?', $drug['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Drug'), array('controller' => 'drugs', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Prices'); ?></h3>
                        <?php if (!empty($license['Price'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('License Id'); ?></th>
                                    <th><?php echo __('Nhi Id'); ?></th>
                                    <th><?php echo __('Nhi Dosage'); ?></th>
                                    <th><?php echo __('Nhi Unit'); ?></th>
                                    <th><?php echo __('Date Begin'); ?></th>
                                    <th><?php echo __('Date End'); ?></th>
                                    <th><?php echo __('Nhi Price'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Price'] as $price): ?>
                                    <tr>
                                        <td><?php echo $price['id']; ?></td>
                                        <td><?php echo $price['license_id']; ?></td>
                                        <td><?php echo $price['nhi_id']; ?></td>
                                        <td><?php echo $price['nhi_dosage']; ?></td>
                                        <td><?php echo $price['nhi_unit']; ?></td>
                                        <td><?php echo $price['date_begin']; ?></td>
                                        <td><?php echo $price['date_end']; ?></td>
                                        <td><?php echo $price['nhi_price']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'prices', 'action' => 'view', $price['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'prices', 'action' => 'edit', $price['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'prices', 'action' => 'delete', $price['id']), array(), __('Are you sure you want to delete # %s?', $price['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Price'), array('controller' => 'prices', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Links'); ?></h3>
                        <?php if (!empty($license['Link'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('License Id'); ?></th>
                                    <th><?php echo __('Url'); ?></th>
                                    <th><?php echo __('Title'); ?></th>
                                    <th><?php echo __('Type'); ?></th>
                                    <th><?php echo __('Sort'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Link'] as $link): ?>
                                    <tr>
                                        <td><?php echo $link['id']; ?></td>
                                        <td><?php echo $link['license_id']; ?></td>
                                        <td><?php echo $link['url']; ?></td>
                                        <td><?php echo $link['title']; ?></td>
                                        <td><?php echo $link['type']; ?></td>
                                        <td><?php echo $link['sort']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'links', 'action' => 'view', $link['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'links', 'action' => 'edit', $link['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'links', 'action' => 'delete', $link['id']), array(), __('Are you sure you want to delete # %s?', $link['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Ingredients Licenses'); ?></h3>
                        <?php if (!empty($license['IngredientsLicense'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('License Id'); ?></th>
                                    <th><?php echo __('Ingredient Id'); ?></th>
                                    <th><?php echo __('Remark'); ?></th>
                                    <th><?php echo __('Name'); ?></th>
                                    <th><?php echo __('Dosage Text'); ?></th>
                                    <th><?php echo __('Dosage'); ?></th>
                                    <th><?php echo __('Unit'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['IngredientsLicense'] as $ingredientsLicense): ?>
                                    <tr>
                                        <td><?php echo $ingredientsLicense['id']; ?></td>
                                        <td><?php echo $ingredientsLicense['license_id']; ?></td>
                                        <td><?php echo $ingredientsLicense['ingredient_id']; ?></td>
                                        <td><?php echo $ingredientsLicense['remark']; ?></td>
                                        <td><?php echo $ingredientsLicense['name']; ?></td>
                                        <td><?php echo $ingredientsLicense['dosage_text']; ?></td>
                                        <td><?php echo $ingredientsLicense['dosage']; ?></td>
                                        <td><?php echo $ingredientsLicense['unit']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'ingredients_licenses', 'action' => 'view', $ingredientsLicense['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'ingredients_licenses', 'action' => 'edit', $ingredientsLicense['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ingredients_licenses', 'action' => 'delete', $ingredientsLicense['id']), array(), __('Are you sure you want to delete # %s?', $ingredientsLicense['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Ingredients License'), array('controller' => 'ingredients_licenses', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Attachments'); ?></h3>
                        <?php if (!empty($license['Attachment'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('Model'); ?></th>
                                    <th><?php echo __('Foreign Key'); ?></th>
                                    <th><?php echo __('Dirname'); ?></th>
                                    <th><?php echo __('Basename'); ?></th>
                                    <th><?php echo __('Checksum'); ?></th>
                                    <th><?php echo __('Alternative'); ?></th>
                                    <th><?php echo __('Group'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('Modified'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Attachment'] as $attachment): ?>
                                    <tr>
                                        <td><?php echo $attachment['id']; ?></td>
                                        <td><?php echo $attachment['model']; ?></td>
                                        <td><?php echo $attachment['foreign_key']; ?></td>
                                        <td><?php echo $attachment['dirname']; ?></td>
                                        <td><?php echo $attachment['basename']; ?></td>
                                        <td><?php echo $attachment['checksum']; ?></td>
                                        <td><?php echo $attachment['alternative']; ?></td>
                                        <td><?php echo $attachment['group']; ?></td>
                                        <td><?php echo $attachment['created']; ?></td>
                                        <td><?php echo $attachment['modified']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'attachments', 'action' => 'view', $attachment['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'attachments', 'action' => 'edit', $attachment['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'attachments', 'action' => 'delete', $attachment['id']), array(), __('Are you sure you want to delete # %s?', $attachment['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Categories'); ?></h3>
                        <?php if (!empty($license['Category'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('Parent Id'); ?></th>
                                    <th><?php echo __('Code'); ?></th>
                                    <th><?php echo __('Name'); ?></th>
                                    <th><?php echo __('Name Chinese'); ?></th>
                                    <th><?php echo __('Lft'); ?></th>
                                    <th><?php echo __('Rght'); ?></th>
                                    <th><?php echo __('Count Daily'); ?></th>
                                    <th><?php echo __('Count All'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Category'] as $category): ?>
                                    <tr>
                                        <td><?php echo $category['id']; ?></td>
                                        <td><?php echo $category['parent_id']; ?></td>
                                        <td><?php echo $category['code']; ?></td>
                                        <td><?php echo $category['name']; ?></td>
                                        <td><?php echo $category['name_chinese']; ?></td>
                                        <td><?php echo $category['lft']; ?></td>
                                        <td><?php echo $category['rght']; ?></td>
                                        <td><?php echo $category['count_daily']; ?></td>
                                        <td><?php echo $category['count_all']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'categories', 'action' => 'view', $category['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'categories', 'action' => 'edit', $category['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'categories', 'action' => 'delete', $category['id']), array(), __('Are you sure you want to delete # %s?', $category['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Ingredients'); ?></h3>
                        <?php if (!empty($license['Ingredient'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('Name'); ?></th>
                                    <th><?php echo __('Count Licenses'); ?></th>
                                    <th><?php echo __('Count Daily'); ?></th>
                                    <th><?php echo __('Count All'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Ingredient'] as $ingredient): ?>
                                    <tr>
                                        <td><?php echo $ingredient['id']; ?></td>
                                        <td><?php echo $ingredient['name']; ?></td>
                                        <td><?php echo $ingredient['count_licenses']; ?></td>
                                        <td><?php echo $ingredient['count_daily']; ?></td>
                                        <td><?php echo $ingredient['count_all']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'ingredients', 'action' => 'view', $ingredient['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'ingredients', 'action' => 'edit', $ingredient['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ingredients', 'action' => 'delete', $ingredient['id']), array(), __('Are you sure you want to delete # %s?', $ingredient['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="related">
                        <h3><?php echo __('Related Articles'); ?></h3>
                        <?php if (!empty($license['Article'])): ?>
                            <table cellpadding = "0" cellspacing = "0">
                                <tr>
                                    <th><?php echo __('Id'); ?></th>
                                    <th><?php echo __('Title'); ?></th>
                                    <th><?php echo __('Body'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('Modified'); ?></th>
                                    <th><?php echo __('Url'); ?></th>
                                    <th><?php echo __('Date Published'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                <?php foreach ($license['Article'] as $article): ?>
                                    <tr>
                                        <td><?php echo $article['id']; ?></td>
                                        <td><?php echo $article['title']; ?></td>
                                        <td><?php echo $article['body']; ?></td>
                                        <td><?php echo $article['created']; ?></td>
                                        <td><?php echo $article['modified']; ?></td>
                                        <td><?php echo $article['url']; ?></td>
                                        <td><?php echo $article['date_published']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('View'), array('controller' => 'articles', 'action' => 'view', $article['id'])); ?>
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'articles', 'action' => 'edit', $article['id'])); ?>
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'articles', 'action' => 'delete', $article['id']), array(), __('Are you sure you want to delete # %s?', $article['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                        <div class="actions">
                            <ul>
                                <li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
