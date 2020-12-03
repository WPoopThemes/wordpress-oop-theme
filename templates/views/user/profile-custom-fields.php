<h3>Profile Fields</h3>

<table class="form-table">

  <tr>
    <th><label for="profile_image">Profile Image</label></th>

    <?php if (get_the_author_meta('profile_image', $user->ID)) : ?>
      <td>
        <img src="<?php echo esc_attr(get_the_author_meta('profile_image', $user->ID)); ?>" alt="" style="width:100px; height:100px;" />
      </td>
    <?php else : ?>
      <td>
        <img src="http://2.gravatar.com/avatar/8a0545b47246165bb1882d2c51661c35?s=96&d=mm&r=g" alt="" style="width:100px; height:100px;" />
      </td>
    <?php endif; ?>
  </tr>

  <tr>
    <th><label for="gender">Gender</label></th>

    <td>
      <input type="text" name="gender" id="gender" value="<?php echo esc_attr(get_the_author_meta('gender', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label>Looking for</label></th>

    <td>
      <div>
        <label for="looking_for_a_male">
          <input type="checkbox" name="looking_for_a_male" id="looking_for_a_male" <?php //echo esc_attr( get_the_author_meta( 'looking_for_a_male', $user->ID ) ); 
                                                                                    ?>>
          Male
        </label>
      </div>
      <div>
        <label for="looking_for_a_female">
          <input type="checkbox" name="looking_for_a_female" id="looking_for_a_female" <?php //echo esc_attr( get_the_author_meta( 'looking_for_a_female', $user->ID ) ); 
                                                                                        ?>>
          Female
        </label>
      </div>
      <div>
        <label for="looking_for_a_couple">
          <input type="checkbox" name="looking_for_a_couple" id="looking_for_a_couple" <?php //echo esc_attr( get_the_author_meta( 'looking_for_a_couple', $user->ID ) ); 
                                                                                        ?>>
          Couple
        </label>
      </div>
      <div>
        <label for="looking_for_a_transgender">
          <input type="checkbox" name="looking_for_a_transgender" id="looking_for_a_transgender" <?php //echo esc_attr( get_the_author_meta( 'looking_for_a_transgender', $user->ID ) ); 
                                                                                                  ?>>
          Transgender
        </label>
      </div>
    </td>
  </tr>

  <tr>
    <th><label for="age">Age</label></th>

    <td>
      <input type="text" name="age" id="age" value="<?php echo esc_attr(get_the_author_meta('age', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="orientation">Orientation</label></th>

    <td>
      <input type="text" name="orientation" id="orientation" value="<?php echo esc_attr(get_the_author_meta('orientation', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="smoker">Smoker</label></th>

    <td>
      <input type="text" name="smoker" id="smoker" value="<?php echo esc_attr(get_the_author_meta('smoker', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="alcohol">Alcohol</label></th>

    <td>
      <input type="text" name="alcohol" id="alcohol" value="<?php echo esc_attr(get_the_author_meta('alcohol', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="country">Country</label></th>

    <td>
      <input type="text" name="country" id="country" value="<?php echo esc_attr(get_the_author_meta('country', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="city">City</label></th>

    <td>
      <input type="text" name="city" id="city" value="<?php echo esc_attr(get_the_author_meta('city', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="relationship">Status</label></th>

    <td>
      <input type="text" name="relationship" id="relationship" value="<?php echo esc_attr(get_the_author_meta('relationship', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="dob">Date of birth</label></th>

    <td>
      <input type="text" name="dob" id="dob" value="<?php echo esc_attr(get_the_author_meta('dob', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="height">Height</label></th>

    <td>
      <input type="number" name="height" id="height" value="<?php echo esc_attr(get_the_author_meta('height', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="weight">Weight</label></th>

    <td>
      <input type="number" name="weight" id="weight" value="<?php echo esc_attr(get_the_author_meta('weight', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="eye_color">Eye color</label></th>

    <td>
      <input type="text" name="eye_color" id="eye_color" value="<?php echo esc_attr(get_the_author_meta('eye_color', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="hair_color">Hair color</label></th>

    <td>
      <input type="text" name="hair_color" id="hair_color" value="<?php echo esc_attr(get_the_author_meta('hair_color', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label>Age preference</label></th>

    <td>
      <label for="age_from" style="display:block; margin-bottom:5px;">From</label>
      <input type="number" name="age_from" id="age_from" value="<?php echo esc_attr(get_the_author_meta('age_from', $user->ID)); ?>" class="regular-text" /><br /><br />
      <label for="age_to" style="display:block; margin-bottom:5px;">To</label>
      <input type="number" name="age_to" id="age_to" value="<?php echo esc_attr(get_the_author_meta('age_to', $user->ID)); ?>" class="regular-text" /><br />
    </td>
  </tr>

  <tr>
    <th><label for="hobbies">Hobbies</label></th>

    <td>
      <textarea name="hobbies" id="hobbies" cols="30" rows="10" value="<?php echo esc_attr(get_the_author_meta('hobbies', $user->ID)); ?>" class="regular-text"></textarea>
    </td>
  </tr>

</table>